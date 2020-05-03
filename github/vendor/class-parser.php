<?php

namespace WordPressdotorg\Plugin_Directory\Readme;

/**
 * WordPress.org Plugin Readme Parser.
 *
 * Based on Baikonur_ReadmeParser from https://github.com/rmccue/WordPress-Readme-Parser
 *
 * @package WordPressdotorg\Plugin_Directory\Readme
 */
class Parser {

	/**
	 * @var string
	 */
	public $name = '';

	/**
	 * @var array
	 */
	public $tags = array();

	/**
	 * @var string
	 */
	public $requires = '';

	/**
	 * @var string
	 */
	public $tested = '';

	/**
	 * @var array
	 */
	public $contributors = array();

	/**
	 * @var string
	 */
	public $stable_tag = '';

	/**
	 * @var string
	 */
	public $donate_link = '';

	/**
	 * @var string
	 */
	public $short_description = '';

	/**
	 * @var array
	 */
	public $sections = array();

	/**
	 * @var array
	 */
	public $upgrade_notice = array();

	/**
	 * @var array
	 */
	public $screenshots = array();

	/**
	 * @var array
	 */
	public $faq = array();

	/**
	 * These are the readme sections that we expect.
	 *
	 * @var array
	 */
	private $expected_sections = array(
		'description',
		'installation',
		'faq',
		'screenshots',
		'changelog',
		'upgrade_notice',
		'other_notes',
	);

	/**
	 * We alias these sections, from => to
	 *
	 * @var array
	 */
	private $alias_sections = array(
		'frequently_asked_questions' => 'faq',
		'change_log'                 => 'changelog',
		'screenshot'                 => 'screenshots',
	);

	/**
	 * These are the valid header mappings for the header.
	 *
	 * @var array
	 */
	private $valid_headers = array(
		'tested'            => 'tested',
		'tested up to'      => 'tested',
		'requires'          => 'requires',
		'requires at least' => 'requires',
		'tags'              => 'tags',
		'contributors'      => 'contributors',
		'donate link'       => 'donate_link',
		'stable tag'        => 'stable_tag',
	);

	/**
	 * Parser constructor.
	 *
	 * @param string $file
	 */
	public function __construct( $file ) {
		if ( $file ) {
			$this->parse_readme( $file );
		}
	}

	/**
	 * @param string $file
	 *
	 * @return bool
	 */
	protected function parse_readme( $file ) {

		/**
		 * Mod for GitHub Updater.
		 */
		//$contents = file_get_contents( $file );
		$contents = $file;

		$contents = preg_split( '!\R!u', $contents );
		$contents = array_map( array( $this, 'strip_newlines' ), $contents );

		// Strip UTF8 BOM if present.
		if ( 0 === strpos( $contents[0], "\xEF\xBB\xBF" ) ) {
			$contents[0] = substr( $contents[0], 3 );
		}

		// Convert UTF-16 files.
		if ( 0 === strpos( $contents[0], "\xFF\xFE" ) ) {
			foreach ( $contents as $i => $line ) {
				$contents[ $i ] = mb_convert_encoding( $line, 'UTF-8', 'UTF-16' );
			}
		}

		$line       = $this->get_first_nonwhitespace( $contents );
		$this->name = $this->sanitize_text( trim( $line, "#= \t\0\x0B" ) );

		// Strip Github style header\n==== underlines.
		if ( ! empty( $contents ) && '' === trim( $contents[0], '=-' ) ) {
			array_shift( $contents );
		}

		// Handle readme's which do `=== Plugin Name ===\nMy SuperAwesomePlugin Name\n...`
		if ( 'plugin name' == strtolower( $this->name ) ) {
			$this->name = $line = $this->get_first_nonwhitespace( $contents );

			// Ensure that the line read wasn't an actual header or description.
			if ( strlen( $line ) > 50 || preg_match( '~^(' . implode( '|', array_keys( $this->valid_headers ) ) . ')\s*:~i', $line ) ) {
				$this->name = false;
				array_unshift( $contents, $line );
			}
		}

		// Parse headers.
		$headers = array();

		$line = $this->get_first_nonwhitespace( $contents );
		do {
			$value = null;
			if ( false === strpos( $line, ':' ) ) {

				// Some plugins have line-breaks within the headers.
				if ( ! empty( $line ) ) {
					break;
				} else {
					continue;
				}
			}

			$bits = explode( ':', trim( $line ), 2 );
			list( $key, $value ) = $bits;
			$key = strtolower( trim( $key, " \t*-\r\n" ) );
			if ( isset( $this->valid_headers[ $key ] ) ) {
				$headers[ $this->valid_headers[ $key ] ] = trim( $value );
			}
		} while ( ( $line = array_shift( $contents ) ) !== null );
		array_unshift( $contents, $line );

		if ( ! empty( $headers['tags'] ) ) {
			$this->tags = explode( ',', $headers['tags'] );
			$this->tags = array_map( 'trim', $this->tags );
			$this->tags = array_filter( $this->tags );
			$this->tags = array_slice( $this->tags, 0, 5 );
		}
		if ( ! empty( $headers['requires'] ) ) {
			$this->requires = $headers['requires'];
		}
		if ( ! empty( $headers['tested'] ) ) {
			$this->tested = $headers['tested'];
		}
		if ( ! empty( $headers['contributors'] ) ) {
			$this->contributors = explode( ',', $headers['contributors'] );
			$this->contributors = array_map( 'trim', $this->contributors );
			$this->contributors = $this->sanitize_contributors( $this->contributors );
		}
		if ( ! empty( $headers['stable_tag'] ) ) {
			$this->stable_tag = $this->sanitize_stable_tag( $headers['stable_tag'] );
		}
		if ( ! empty( $headers['donate_link'] ) ) {
			$this->donate_link = $headers['donate_link'];
		}

		// Parse the short description.
		while ( ( $line = array_shift( $contents ) ) !== null ) {
			$trimmed = trim( $line );
			if ( empty( $trimmed ) ) {
				$this->short_description .= "\n";
				continue;
			}
			if ( ( '=' === $trimmed[0] && isset( $trimmed[1] ) && '=' === $trimmed[1] ) ||
			     ( '#' === $trimmed[0] && isset( $trimmed[1] ) && '#' === $trimmed[1] )
			) {

				// Stop after any Markdown heading.
				array_unshift( $contents, $line );
				break;
			}

			$this->short_description .= $line . "\n";
		}
		$this->short_description = trim( $this->short_description );

		/*
		 * Parse the rest of the body.
		 * Pre-fill the sections, we'll filter out empty sections later.
		 */
		$this->sections = array_fill_keys( $this->expected_sections, '' );
		$current        = $section_name = $section_title = '';
		while ( ( $line = array_shift( $contents ) ) !== null ) {
			$trimmed = trim( $line );
			if ( empty( $trimmed ) ) {
				$current .= "\n";
				continue;
			}

			// Stop only after a ## Markdown header, not a ###.
			if ( ( '=' === $trimmed[0] && isset( $trimmed[1] ) && '=' === $trimmed[1] ) ||
			     ( '#' === $trimmed[0] && isset( $trimmed[1] ) && '#' === $trimmed[1] && isset( $trimmed[2] ) && '#' !== $trimmed[2] )
			) {

				if ( ! empty( $section_name ) ) {
					$this->sections[ $section_name ] .= trim( $current );
				}

				$current       = '';
				$section_title = trim( $line, "#= \t" );
				$section_name  = strtolower( str_replace( ' ', '_', $section_title ) );

				if ( isset( $this->alias_sections[ $section_name ] ) ) {
					$section_name = $this->alias_sections[ $section_name ];
				}

				// If we encounter an unknown section header, include the provided Title, we'll filter it to other_notes later.
				if ( ! in_array( $section_name, $this->expected_sections ) ) {
					$current .= '<h3>' . $section_title . '</h3>';
					$section_name = 'other_notes';
				}
				continue;
			}

			$current .= $line . "\n";
		}

		if ( ! empty( $section_name ) ) {
			$this->sections[ $section_name ] .= trim( $current );
		}

		// Filter out any empty sections.
		$this->sections = array_filter( $this->sections );

		// Use the first line of the description for the short description if not provided.
		if ( empty( $this->short_description ) && ! empty( $this->sections['description'] ) ) {
			$description = array_filter( explode( "\n", $this->sections['description'] ) );
			$this->short_description = $description[0];
			//$this->short_description = array_filter( explode( "\n", $this->sections['description'] ) )[0];
		}

		// Use the short description for the description section if not provided.
		if ( empty( $this->sections['description'] ) ) {
			$this->sections['description'] = $this->short_description;
		}

		// Parse out the Upgrade Notice section into it's own data.
		if ( isset( $this->sections['upgrade_notice'] ) ) {
			$this->upgrade_notice = $this->parse_section( $this->sections['upgrade_notice'] );
			$this->upgrade_notice = array_map( array( $this, 'sanitize_text' ), $this->upgrade_notice );
			unset( $this->sections['upgrade_notice'] );
		}

		// Display FAQs as a definition list.
		if ( isset( $this->sections['faq'] ) ) {
			$this->faq             = $this->parse_section( $this->sections['faq'] );
			$this->sections['faq'] = '';
		}

		// Markdownify!
		$this->sections       = array_map( array( $this, 'parse_markdown' ), $this->sections );
		$this->upgrade_notice = array_map( array( $this, 'parse_markdown' ), $this->upgrade_notice );
		$this->faq            = array_map( array( $this, 'parse_markdown' ), $this->faq );

		// Sanitize and trim the short_description to match requirements.
		$this->short_description = $this->sanitize_text( $this->short_description );
		$this->short_description = $this->parse_markdown( $this->short_description );
		$this->short_description = wp_strip_all_tags( $this->short_description );
		$this->short_description = $this->trim_length( $this->short_description, 150 );

		if ( isset( $this->sections['screenshots'] ) ) {
			preg_match_all( '#<li>(.*?)</li>#is', $this->sections['screenshots'], $screenshots, PREG_SET_ORDER );
			if ( $screenshots ) {
				$i = 1; // Screenshots start from 1.
				foreach ( $screenshots as $ss ) {
					$this->screenshots[ $i ++ ] = $this->filter_text( $ss[1] );
				}
			}
			unset( $this->sections['screenshots'] );
		}

		if ( ! empty( $this->faq ) ) {
			// If the FAQ contained data we couldn't parse, we'll treat it as freeform and display it before any questions which are found.
			if ( isset( $this->faq[''] ) ) {
				$this->sections['faq'] .= $this->faq[''];
				unset( $this->faq[''] );
			}

			if ( $this->faq ) {
				$this->sections['faq'] .= "\n<dl>\n";
				foreach ( $this->faq as $question => $answer ) {
					$this->sections['faq'] .= "<dt>{$question}</dt>\n<dd>{$answer}</dd>\n";
				}
				$this->sections['faq'] .= "\n</dl>\n";
			}
		}

		// Filter the HTML.
		$this->sections = array_map( array( $this, 'filter_text' ), $this->sections );

		return true;
	}

	/**
	 * @access protected
	 *
	 * @param string $contents
	 *
	 * @return string
	 */
	protected function get_first_nonwhitespace( &$contents ) {
		while ( ( $line = array_shift( $contents ) ) !== null ) {
			$trimmed = trim( $line );
			if ( ! empty( $trimmed ) ) {
				break;
			}
		}

		return $line;
	}

	/**
	 * @access protected
	 *
	 * @param string $line
	 *
	 * @return string
	 */
	protected function strip_newlines( $line ) {
		return rtrim( $line, "\r\n" );
	}

	/**
	 * @access protected
	 *
	 * @param string $desc
	 * @param int    $length
	 *
	 * @return string
	 */
	protected function trim_length( $desc, $length = 150 ) {
		if ( mb_strlen( $desc ) > $length ) {
			$desc = mb_substr( $desc, 0, $length ) . ' &hellip;';

			// If not a full sentence, and one ends within 20% of the end, trim it to that.
			if ( '.' !== mb_substr( $desc, - 1 ) && ( $pos = mb_strrpos( $desc, '.' ) ) > ( 0.8 * $length ) ) {
				$desc = mb_substr( $desc, 0, $pos + 1 );
			}
		}

		return trim( $desc );
	}

	/**
	 * @access protected
	 *
	 * @param string $text
	 *
	 * @return string
	 */
	protected function filter_text( $text ) {
		$text = trim( $text );

		$allowed = array(
			'a'          => array(
				'href'  => true,
				'title' => true,
				'rel'   => true,
			),
			'blockquote' => array(
				'cite' => true,
			),
			'br'         => true,
			'p'          => true,
			'code'       => true,
			'pre'        => true,
			'em'         => true,
			'strong'     => true,
			'ul'         => true,
			'ol'         => true,
			'dl'         => true,
			'dt'         => true,
			'dd'         => true,
			'li'         => true,
			'h3'         => true,
			'h4'         => true,
		);

		$text = force_balance_tags( $text );
		// TODO: make_clickable() will act inside shortcodes.
		//$text = make_clickable( $text );

		$text = wp_kses( $text, $allowed );

		// wpautop() will eventually replace all \n's with <br>s, and that isn't what we want.
		$text = preg_replace( "/(?<![> ])\n/", ' ', $text );

		$text = trim( $text );

		return $text;
	}

	/**
	 * @access protected
	 *
	 * @param string $text
	 *
	 * @return string
	 */
	protected function sanitize_text( $text ) { // not fancy
		$text = strip_tags( $text );
		$text = esc_html( $text );
		$text = trim( $text );

		return $text;
	}

	/**
	 * Sanitize provided contributors to valid WordPress users
	 *
	 * @param array $users Array of user_login's or user_nicename's.
	 *
	 * @return array Array of user_logins.
	 */
	protected function sanitize_contributors( $users ) {
		foreach ( $users as $i => $name ) {
			if ( $user = get_user_by( 'login', $name ) ) {

				// Check the case of the user login matches.
				if ( $name !== $user->user_login ) {
					$users[ $i ] = $user->user_login;
				}
			} elseif ( false !== ( $user = get_user_by( 'slug', $name ) ) ) {

				// Overwrite the nicename with the user_login.
				$users[ $i ] = $user->user_login;
			} else {

				// Unknown user, we'll skip these entirely to encourage correct readme files.
				unset( $users[ $i ] );
			}
		}

		return $users;
	}

	/**
	 * Sanitize the provided stable tag to something we expect.
	 *
	 * @param string $stable_tag the raw Stable Tag line from the readme.
	 *
	 * @return string The sanitized $stable_tag.
	 */
	protected function sanitize_stable_tag( $stable_tag ) {
		$stable_tag = trim( $stable_tag );
		$stable_tag = trim( $stable_tag, '"\'' ); // "trunk"
		$stable_tag = preg_replace( '!^/?tags/!i', '', $stable_tag ); // "tags/1.2.3"
		$stable_tag = preg_replace( '![^a-z0-9_.-]!i', '', $stable_tag );

		// If the stable_tag begins with a ., we treat it as 0.blah.
		if ( '.' == substr( $stable_tag, 0, 1 ) ) {
			$stable_tag = "0{$stable_tag}";
		}

		return $stable_tag;
	}

	/**
	 * Parses a slice of lines from the file into an array of Heading => Content.
	 *
	 * We assume that every heading encountered is a new item, and not a sub heading.
	 * We support headings which are either `= Heading`, `# Heading` or `** Heading`.
	 *
	 * @param string|array $lines The lines of the section to parse.
	 *
	 * @return array
	 */
	protected function parse_section( $lines ) {
		$key    = $value = '';
		$return = array();

		if ( ! is_array( $lines ) ) {
			$lines = explode( "\n", $lines );
		}

		while ( ( $line = array_shift( $lines ) ) !== null ) {
			$trimmed = trim( $line );
			if ( ! $trimmed ) {
				$value .= "\n";
				continue;
			}

			// Normal headings (##.. == ... ==) are matched if they exist, Bold is only used if it starts and ends the line.
			if ( $trimmed[0] == '#' || $trimmed[0] == '=' || ( substr( $trimmed, 0, 2 ) == '**' && substr( $trimmed, - 2 ) == '**' ) ) {
				if ( $value ) {
					$return[ $key ] = trim( $value );
				}

				$value = '';
				// Trim off the first character of the line, as we know that's the heading style we're expecting to remove.
				$key = trim( $line, $trimmed[0] . " \t" );
				continue;
			}

			$value .= $line . "\n";
		}

		if ( $key || $value ) {
			$return[ $key ] = trim( $value );
		}

		return $return;
	}

	/**
	 * @param string $text
	 *
	 * @return string
	 */
	protected function parse_markdown( $text ) {
		static $markdown = null;

		if ( is_null( $markdown ) ) {
			$markdown = new Markdown();
		}

		return $markdown->transform( $text );
	}
}
