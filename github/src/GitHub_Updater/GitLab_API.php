<?php
/**
 * GitHub Updater
 *
 * @package   GitHub_Updater
 * @author    Andy Fragen
 * @license   GPL-2.0+
 * @link      https://github.com/afragen/github-updater
 */

namespace Fragen\GitHub_Updater;

/*
 * Exit if called directly.
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class GitLab_API
 *
 * Get remote data from a GitLab repo.
 *
 * @package Fragen\GitHub_Updater
 * @author  Andy Fragen
 */
class GitLab_API extends API {

	/**
	 * Holds loose class method name.
	 *
	 * @var null
	 */
	protected static $method = null;

	/**
	 * Constructor.
	 *
	 * @param object $type
	 */
	public function __construct( $type ) {
		$this->type     = $type;
		parent::$hours  = 12;
		$this->response = $this->get_transient();

		if ( ! isset( self::$options['gitlab_access_token'] ) ) {
			self::$options['gitlab_access_token'] = null;
		}
		if ( ! isset( self::$options['gitlab_enterprise_token'] ) ) {
			self::$options['gitlab_enterprise_token'] = null;
		}
		if (
			empty( self::$options['gitlab_access_token'] ) ||
			( empty( self::$options['gitlab_enterprise_token'] ) && ! empty( $type->enterprise ) )
		) {
			Messages::instance()->create_error_message( 'gitlab' );
		}
		add_site_option( 'github_updater', self::$options );
	}

	/**
	 * Read the remote file and parse headers.
	 *
	 * @param $file
	 *
	 * @return bool
	 */
	public function get_remote_info( $file ) {
		$response = isset( $this->response[ $file ] ) ? $this->response[ $file ] : false;

		if ( ! $response ) {
			$id           = $this->get_gitlab_id();
			self::$method = 'file';

			if ( empty( $this->type->branch ) ) {
				$this->type->branch = 'master';
			}

			$response = $this->api( '/projects/' . $id . '/repository/files?file_path=' . $file );

			if ( empty( $response ) || ! isset( $response->content ) ) {
				return false;
			}

			if ( $response ) {
				$contents = base64_decode( $response->content );
				$response = $this->get_file_headers( $contents, $this->type->type );
				$this->set_transient( $file, $response );
			}
		}

		if ( $this->validate_response( $response ) || ! is_array( $response ) ) {
			return false;
		}

		$this->set_file_info( $response );

		return true;
	}

	/**
	 * Get remote info for tags.
	 *
	 * @return bool
	 */
	public function get_remote_tag() {
		$repo_type = $this->return_repo_type();
		$response  = isset( $this->response['tags'] ) ? $this->response['tags'] : false;

		if ( $this->exit_no_update( $response, true ) ) {
			return false;
		}

		if ( ! $response ) {
			$id           = $this->get_gitlab_id();
			self::$method = 'tags';
			$response     = $this->api( '/projects/' . $id . '/repository/tags' );

			if ( ! $response ) {
				$response          = new \stdClass();
				$response->message = 'No tags found';
			}

			if ( $response ) {
				$this->set_transient( 'tags', $response );
			}
		}

		if ( $this->validate_response( $response ) ) {
			return false;
		}

		$this->parse_tags( $response, $repo_type );

		return true;
	}

	/**
	 * Read the remote CHANGES.md file.
	 *
	 * @param $changes
	 *
	 * @return bool
	 */
	public function get_remote_changes( $changes ) {
		$response = isset( $this->response['changes'] ) ? $this->response['changes'] : false;

		/*
		 * Set response from local file if no update available.
		 */
		if ( ! $response && ! $this->can_update( $this->type ) ) {
			$response = new \stdClass();
			$content  = $this->get_local_info( $this->type, $changes );
			if ( $content ) {
				$response->content = $content;
				$this->set_transient( 'changes', $response );
			} else {
				$response = false;
			}
		}

		if ( ! $response ) {
			$id           = $this->get_gitlab_id();
			self::$method = 'changes';
			$response     = $this->api( '/projects/' . $id . '/repository/files?file_path=' . $changes );

			if ( $response ) {
				$this->set_transient( 'changes', $response );
			}
		}

		if ( $this->validate_response( $response ) ) {
			return false;
		}

		$changelog = isset( $this->response['changelog'] ) ? $this->response['changelog'] : false;

		if ( ! $changelog ) {
			$parser    = new \Parsedown;
			$changelog = $parser->text( base64_decode( $response->content ) );
			$this->set_transient( 'changelog', $changelog );
		}

		$this->type->sections['changelog'] = $changelog;

		return true;
	}

	/**
	 * Read and parse remote readme.txt.
	 *
	 * @return bool
	 */
	public function get_remote_readme() {
		if ( ! file_exists( $this->type->local_path . 'readme.txt' ) &&
		     ! file_exists( $this->type->local_path_extended . 'readme.txt' )
		) {
			return false;
		}

		$response = isset( $this->response['readme'] ) ? $this->response['readme'] : false;

		/*
		 * Set $response from local file if no update available.
		 */
		if ( ! $response && ! $this->can_update( $this->type ) ) {
			$response = new \stdClass();
			$content  = $this->get_local_info( $this->type, 'readme.txt' );
			if ( $content ) {
				$response->content = $content;
			} else {
				$response = false;
			}
		}

		if ( ! $response ) {
			$id           = $this->get_gitlab_id();
			self::$method = 'readme';
			$response     = $this->api( '/projects/' . $id . '/repository/files?file_path=readme.txt' );

		}
		if ( $response && isset( $response->content ) ) {
			$file     = base64_decode( $response->content );
			$parser   = new Readme_Parser( $file );
			$response = $parser->parse_data();
			$this->set_transient( 'readme', $response );
		}

		if ( $this->validate_response( $response ) ) {
			return false;
		}

		$this->set_readme_info( $response );

		return true;
	}

	/**
	 * Read the repository meta from API.
	 *
	 * @return bool
	 */
	public function get_repo_meta() {
		$response = isset( $this->response['meta'] ) ? $this->response['meta'] : false;

		if ( $this->exit_no_update( $response ) ) {
			return false;
		}

		if ( ! $response ) {
			self::$method = 'meta';
			$projects     = isset( $this->response['projects'] ) ? $this->response['projects'] : false;

			// exit if transient is empty
			if ( ! $projects ) {
				return false;
			}

			foreach ( $projects as $project ) {
				if ( $this->type->repo === $project->path ) {
					$response = $project;
					break;
				}
			}

			if ( $response ) {
				$this->set_transient( 'meta', $response );
			}
		}

		if ( $this->validate_response( $response ) ) {
			return false;
		}

		$this->type->repo_meta = $response;
		$this->add_meta_repo_object();

		return true;
	}

	/**
	 * Create array of branches and download links as array.
	 *
	 * @return bool
	 */
	public function get_remote_branches() {
		$branches = array();
		$response = isset( $this->response['branches'] ) ? $this->response['branches'] : false;

		if ( $this->exit_no_update( $response, true ) ) {
			return false;
		}

		if ( ! $response ) {
			$id           = $this->get_gitlab_id();
			self::$method = 'branches';
			$response     = $this->api( '/projects/' . $id . '/repository/branches' );

			if ( $response ) {
				foreach ( $response as $branch ) {
					$branches[ $branch->name ] = $this->construct_download_link( false, $branch->name );
				}
				$this->type->branches = $branches;
				$this->set_transient( 'branches', $branches );

				return true;
			}
		}

		if ( $this->validate_response( $response ) ) {
			return false;
		}

		$this->type->branches = $response;

		return true;
	}

	/**
	 * Construct $this->type->download_link using GitLab API.
	 *
	 * @param boolean $rollback      for theme rollback
	 * @param boolean $branch_switch for direct branch changing
	 *
	 * @return string $endpoint
	 */
	public function construct_download_link( $rollback = false, $branch_switch = false ) {
		/*
		 * Check if using GitLab CE/Enterprise.
		 */
		if ( ! empty( $this->type->enterprise ) ) {
			$gitlab_base = $this->type->enterprise;
		} else {
			$gitlab_base = 'https://gitlab.com';
		}

		$download_link_base = implode( '/', array(
			$gitlab_base,
			$this->type->owner,
			$this->type->repo,
			'repository/archive.zip',
		) );
		$endpoint           = '';

		/*
		 * If release asset.
		 */
		if ( $this->type->release_asset && '0.0.0' !== $this->type->newest_tag ) {
			$download_link_base = $this->make_release_asset_download_link();

			return $this->add_access_token_endpoint( $this, $download_link_base );
		}

		/*
		 * If a branch has been given, only check that for the remote info.
		 * If branch is master (default) and tags are used, use newest tag.
		 */
		if ( 'master' === $this->type->branch && ! empty( $this->type->tags ) ) {
			$endpoint = remove_query_arg( 'ref', $endpoint );
			$endpoint = add_query_arg( 'ref', $this->type->newest_tag, $endpoint );
		} elseif ( ! empty( $this->type->branch ) ) {
			$endpoint = remove_query_arg( 'ref', $endpoint );
			$endpoint = add_query_arg( 'ref', $this->type->branch, $endpoint );
		}

		/*
		 * Check for rollback.
		 */
		if ( ! empty( $_GET['rollback'] ) &&
		     ( isset( $_GET['action'] ) && 'upgrade-theme' === $_GET['action'] ) &&
		     ( isset( $_GET['theme'] ) && $this->type->repo === $_GET['theme'] )
		) {
			$endpoint = remove_query_arg( 'ref', $endpoint );
			$endpoint = add_query_arg( 'ref', esc_attr( $_GET['rollback'] ), $endpoint );
		}

		/*
		 * Create endpoint for branch switching.
		 */
		if ( $branch_switch ) {
			$endpoint = remove_query_arg( 'ref', $endpoint );
			$endpoint = add_query_arg( 'ref', $branch_switch, $endpoint );
		}

		$endpoint = $this->add_access_token_endpoint( $this, $endpoint );

		return $download_link_base . $endpoint;
	}

	/**
	 * Get/process Language Packs.
	 * Language Packs cannot reside on GitLab CE/Enterprise.
	 *
	 * @TODO GitLab CE/Enterprise.
	 *
	 * @param array $headers Array of headers of Language Pack.
	 *
	 * @return bool When invalid response.
	 */
	public function get_language_pack( $headers ) {
		$response = ! empty( $this->response['languages'] ) ? $this->response['languages'] : false;
		$type     = explode( '_', $this->type->type );

		if ( ! $response ) {
			self::$method = 'translation';
			$id           = urlencode( $headers['owner'] . '/' . $headers['repo'] );
			$response     = $this->api( '/projects/' . $id . '/repository/files?file_path=language-pack.json' );

			if ( $this->validate_response( $response ) ) {
				return false;
			}

			if ( $response ) {
				$contents = base64_decode( $response->content );
				$response = json_decode( $contents );

				foreach ( $response as $locale ) {
					$package = array( 'https://gitlab.com', $headers['owner'], $headers['repo'], 'raw/master' );
					$package = implode( '/', $package ) . $locale->package;

					$response->{$locale->language}->package = $package;
					$response->{$locale->language}->type    = $type[1];
					$response->{$locale->language}->version = $this->type->remote_version;
				}

				$this->set_transient( 'languages', $response );
			}
		}
		$this->type->language_packs = $response;
	}

	/**
	 * Add appropriate access token to endpoint.
	 *
	 * @param $git
	 * @param $endpoint
	 *
	 * @access private
	 *
	 * @return string
	 */
	private function add_access_token_endpoint( $git, $endpoint ) {

		// Add GitLab.com Access Token.
		if ( ! empty( parent::$options['gitlab_access_token'] ) ) {
			$endpoint = add_query_arg( 'private_token', parent::$options['gitlab_access_token'], $endpoint );
		}

		// If using GitLab CE/Enterprise header return this endpoint.
		if ( ! empty( $git->type->enterprise ) &&
		     ! empty( parent::$options['gitlab_enterprise_token'] )
		) {
			$endpoint = remove_query_arg( 'private_token', $endpoint );
			$endpoint = add_query_arg( 'private_token', parent::$options['gitlab_enterprise_token'], $endpoint );
		}

		// Add repo access token.
		if ( ! empty( parent::$options[ $git->type->repo ] ) ) {
			$endpoint = remove_query_arg( 'private_token', $endpoint );
			$endpoint = add_query_arg( 'private_token', parent::$options[ $git->type->repo ], $endpoint );
		}

		return $endpoint;
	}

	/**
	 * Add remote data to type object.
	 *
	 * @access private
	 */
	private function add_meta_repo_object() {
		//$this->type->rating       = $this->make_rating( $this->type->repo_meta );
		$this->type->last_updated = $this->type->repo_meta->last_activity_at;
		//$this->type->num_ratings  = $this->type->repo_meta->watchers;
	}

	/**
	 * Create GitLab API endpoints.
	 *
	 * @param $git      object
	 * @param $endpoint string
	 *
	 * @return string
	 */
	protected function add_endpoints( $git, $endpoint ) {

		switch ( self::$method ) {
			case 'projects':
			case 'meta':
			case 'tags':
				break;
			case 'file':
			case 'changes':
			case 'readme':
				$endpoint = add_query_arg( 'ref', $git->type->branch, $endpoint );
				break;
			case 'translation':
				$endpoint = add_query_arg( 'ref', 'master', $endpoint );
				break;
			default:
				break;
		}

		$endpoint = $this->add_access_token_endpoint( $git, $endpoint );

		/*
		 * If using GitLab CE/Enterprise header return this endpoint.
		 */
		if ( ! empty( $git->type->enterprise_api ) ) {
			return $git->type->enterprise_api . $endpoint;
		}

		return $endpoint;
	}

	/**
	 * Get GitLab project ID.
	 *
	 * @return bool|null
	 */
	public function get_gitlab_id() {
		$id       = null;
		$response = isset( $this->response['projects'] ) ? $this->response['projects'] : false;

		if ( ! $response ) {
			self::$method = 'projects';
			$response     = $this->api( '/projects?per_page=100' );
			if ( empty( $response ) ) {
				$id = urlencode( $this->type->owner . '/' . $this->type->repo );

				return $id;
			}
		}

		foreach ( $response as $project ) {
			if ( $this->type->repo === $project->path ) {
				$id = $project->id;
				$this->set_transient( 'projects', $response );
				break;
			}
		}

		return $id;
	}

}
