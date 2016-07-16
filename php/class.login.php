<?php/** * Class handling the admin form login * */class Login{	/**	 * The users' XML	 *	 * @var SimpleXMLfield	 *	 */	private $xml;	/**	 * User data	 *	 * @var String	 *	 */	private $user;	/**	 * User login	 *	 * @var String	 *	 */	private $login;	/**	 * User password	 *	 * @var String	 *	 */	private $password;  /**   * Checks if XML file exists, then sets the XML var.	 * Creates the user on first use	 *   * @param array $post POST vars from the user form	 *   */	public function __construct ( $post )	{		$this -> user = $post['user'];		$this -> xml = new DOMDocument('1.0', 'utf-8');		if( file_exists( dirname( dirname( __FILE__ ) ) . '/xml/ids.xml' ) )			$this -> xml -> load( dirname( dirname( __FILE__ ) ) . '/xml/ids.xml' );		if( $this -> xml -> childNodes->length == 0 )		{			$ids = $this -> xml -> createElement( 'ids' );			$user = $this -> xml -> createElement( $post['user'] );			$element = $this -> xml -> createElement( 'password', md5( $post['password'] ) );			$user -> appendChild( $element );			$ids -> appendChild( $user );			$this -> xml -> appendChild( $ids );			$this -> xml -> saveXML();			$this -> save();		} else $ids = $this -> xml -> childNodes -> item( 0 );		if( $ids -> getElementsByTagName( $this -> user )->length != 0) {			$user = $ids -> getElementsByTagName( $this -> user ) -> item( 0 );			$password = $user -> getElementsByTagName( 'password' ) -> item( 0 );			$this -> password = $password -> nodeValue;		}	}  /**   * Compares passwords input with previously saved password	 *   * @param String $password password's hash	 *   * @return Boolean true password match	 *									false password mismatch	 *   */	public function confirm ( $password )	{		if( md5( $password ) == $this -> password )			return true;		return false;	}  /**   * Saves the XML file   *   */	public function save ()	{		if( file_exists( dirname( dirname( __FILE__ ) ) . '/xml/ids.xml' ) )			unlink( dirname( dirname( __FILE__ ) ) . '/xml/ids.xml' );	 $this -> xml -> save( dirname( dirname( __FILE__ ) ) . '/xml/ids.xml' );	}}