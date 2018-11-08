
/**
  +------------------------------------------+
  | AdSensor - Bot Detection & Cloaking Tool |
  +------------------------------------------+
  by Paul Pierre


  Front-end Tests
    Simulator
      -Audio Context (Android Only)
    Device
      -ontouchstart
      -devicePixelRatio
      -colorDepth
      -screen.Width
      -iOS / Android user-agent
      -browser session history length

  Back-end Tests
      -user-agent heuristics
      -organization
      -connection type (dial-up, cellular, cable/dsl, corporate)
      -geo
      -geo + browser language
      -geo + time of day
      -isp
      -proxy



  NOTES:
    -Save JS timestamp as well as database record insert timestamp
    -On click, have JS store the click timestamp
    -Store user's fingerprint, make it their ID
    -Store campaign
    -Allow time of day, day of week, and months filter
    -Redirect

    tables:
    -redirect
    -campaign
    -cron
    -ip


databasename - adsensor_db
 */

DROP TABLE IF EXISTS `org`;
DROP TABLE IF EXISTS `device`;
DROP TABLE IF EXISTS `ip`;
DROP TABLE IF EXISTS `user`;


/*====
  user
  ====
 */

CREATE TABLE `user`(
 `user_id` int(10) NOT NULL AUTO_INCREMENT,
 `user_fingerprint` varchar(255) NOT NULL,
 `user_view_count` int(5) NOT NULL,
 `user_status` int(3) NOT NULL,
 `user_is_enabled` int(3) NOT NULL,
 `user_tmodified` DATETIME NOT NULL,
 `user_tcreate` DATETIME NOT NULL,
PRIMARY KEY (`user_id`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;



/*=====
  device
  =====
  the only non-NOT NULL fields we will allow will be the client-side data
  because i want to reserve 0 for true and 1 for false, and in the event
  of no data provided, we can leave it as null rather than adopting
  some wonky numbering system
   */

CREATE TABLE `device`(
  `device_id` int(10) NOT NULL AUTO_INCREMENT,

  `user_id` int(10) NOT NULL,

  `device_identifier` varchar(255) NOT NULL,
  `device_identifier_type` int(3) NOT NULL,
  `device_mac_address` varchar(100),
  `device_user_agent` varchar(2500) NOT NULL,
  `device_heuristic` int(3) NOT NULL,
  `device_ontouchstart` int(1) NOT NULL,
  `device_pixel_ratio` float(3 ,3) NOT NULL,
  `device_color_depth` int(2) NOT NULL,
  `device_screen_width` int(4) NOT NULL,
  `device_screen_height` int(4) NOT NULL,
  `device_browser` varchar(255) NOT NULL, /** TODO: UPDATE THIS! **/
  `device_os` varchar(255) NOT NULL, /** TODO: UPDATE THIS! **/
  `device_history_length` int(3),
  `device_locale` varchar(10) NOT NULL,
  `device_plugins` int(2) NOT NULL,
  `device_mimetypes` int(2) NOT NULL,
  `device_hardware_concurrency` int(1) NOT NULL,
  `device_maxtouchpoints` int(1) NOT NULL,
  `device_nav_connection` varchar(10) NOT NULL,
  `device_createtouch` int(1) NOT NULL,
  `device_onorientationchange` int(1) NOT NULL,
  `device_orientation` int(1) NOT NULL,
  `device_duration` int(10) NOT NULL,
  `device_view_count` int(5) NOT NULL,
  `device_timestamp` int(15) NOT NULL,
  `device_audio_context` int(1),
  `device_qc` int(1),
  `device_ss_qc` int(1),
  `device_platform` int(1),
  `device_ss_locale` varchar(50) NOT NULL,
  `device_timezone` int(5) NOT NULL,
  `device_timezone_qc` int(1) NOT NULL,  /** TODO: NEW!!! **/
  `device_character_set` varchar(10) NOT NULL,
  `device_os_version` varchar(255) NOT NULL,
  `device_browser_version` varchar(255) NOT NULL,
  `device_is_bot` int(1) NOT NULL,

  /** SOCIAL MEDIA **/
  `device_session_twitter` int(1) NOT NULL, /** TODO: NEW!!!! **/
  `device_session_reddit` int(1) NOT NULL, /** TODO: NEW!!!! **/
  `device_session_facebook` int(1) NOT NULL, /** TODO: NEW!!!! **/
  `device_session_google` int(1) NOT NULL, /** TODO: NEW!!!! **/
  `device_session_amazon` int(1) NOT NULL, /** TODO: NEW!!!! **/
  `device_session_googleplus` int(1) NOT NULL,

    /** GYROSCOPE **/
  `device_gyro_alpha` float(3,2) NOT NULL, /** TODO: NEW!!!! **/
  `device_gyro_beta` float(3,2) NOT NULL, /** TODO: NEW!!!! **/
  `device_gyro_gamma` float(3,2) NOT NULL, /** TODO: NEW!!!! **/
  `device_gyro_qc`  int(1) NOT NULL,  /** TODO: NEW!!!! **/

  /* If they have developer tools open */
  `device_dev_tool` int(1) NOT NULL,  /** TODO: NEW!!!! **/


  `device_dnt` int(1) NOT NULL,
  `device_adblock` int(1) NOT NULL,
  `device_cookies_enabled` int(1) NOT NULL,
  `device_fonts` int(2) NOT NULL,
  `device_indexed_db` int(1) NOT NULL,
  `device_local_storage` int(1) NOT NULL,
  `device_open_db` int(1) NOT NULL,
  `device_session_storage` int(1) NOT NULL,
  `device_webgl` int(1) NOT NULL,
  `device_flag_browser` int(1) NOT NULL,
  `device_flag_language` int(1) NOT NULL,
  `device_flag_os` int(1) NOT NULL,
  `device_flag_resolution` int(1) NOT NULL,



  `device_tmodified` DATETIME NOT NULL,
  `device_tcreate` DATETIME NOT NULL,
  PRIMARY KEY (`device_id`),
  FOREIGN KEY (`user_id`) REFERENCES user(user_id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*=====
  org
  =====
   */

CREATE TABLE `org`(
  `org_id` int(10) NOT NULL AUTO_INCREMENT,

  `org_name` varchar(255) NOT NULL,
  `org_domain` varchar(255) NOT NULL,

  `org_isp_name` varchar(255) NOT NULL,
  `org_asn` int(10) NOT NULL,
  `org_asn_name` varchar(255) NOT NULL,

  `org_type` int(3) NOT NULL,
  `org_status` int(3) NOT NULL,

  `org_tmodified` DATETIME NOT NULL,
  `org_tcreate` DATETIME NOT NULL,
  PRIMARY KEY (`org_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `org` ADD UNIQUE `unique_index`(`org_name`, `org_domain`);

/*===
  ip
  ===
 */

CREATE TABLE `ip`(
  `ip_id` int(10) NOT NULL AUTO_INCREMENT,

  `user_id` int(10) NOT NULL,
  `org_id` int(10) NOT NULL,
  `device_id` int(10) NOT NULL,

  `ip_address` varchar(25) NOT NULL,
  `ip_hostname` varchar(255) NOT NULL,

  `ip_country` varchar(3) NOT NULL,
  `ip_city` varchar(255) NOT NULL,
  `ip_location` varchar(500) NOT NULL,
  `ip_postal_code` varchar(100) NOT NULL,
  `ip_domain` varchar(255) NOT NULL,
  `ip_is_mraid` int(1) NOT NULL,

  `ip_category` int(1) NOT NULL, /** is it a user=0, facebook, google, ad network etc. **/

  `ip_connection` int(3) NOT NULL, /** connection type **/
  `ip_referrer` varchar(500) NOT NULL,
  `ip_url` varchar(500) NOT NULL,
  `ip_campaign_id` varchar(50) NOT NULL,

  `ip_campaign_click_id` varchar(100) NOT NULL, /** TODO: NEW!!!! **/

  `ip_zone_id` varchar(50) NOT NULL,
  `ip_note` varchar(255) NOT NULL,
  `ip_asn` varchar(10) NOT NULL,
  `ip_asn_name` varchar(255) NOT NULL,
  `ip_is_monitor` int(1) NOT NULL,
  `ip_accept_header` varchar(50) NOT NULL,
  `ip_timezone` int (4) NOT NULL,
  `ip_metro_code` varchar(100) NOT NULL,

  `ip_status` int(3) NOT NULL,
  `ip_is_enabled` int(1) NOT NULL,

  `ip_tmodified` DATETIME NOT NULL,
  `ip_tcreate` DATETIME NOT NULL,
  PRIMARY KEY (`ip_id`),

  FOREIGN KEY (`user_id`) REFERENCES user(user_id),
  /* FOREIGN KEY (`org_id`) REFERENCES org(org_id),*/

  FOREIGN KEY (`device_id`) REFERENCES device(device_id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/**
ALTER TABLE ip
ADD COLUMN `ip_campaign_click_id` varchar(100) NOT NULL;

ALTER TABLE device
ADD COLUMN  `device_session_twitter` int(1) NOT NULL,
  ADD COLUMN `device_session_reddit` int(1) NOT NULL,
  ADD COLUMN `device_session_facebook` int(1) NOT NULL,
  ADD COLUMN `device_session_google` int(1) NOT NULL,
  ADD COLUMN `device_session_amazon` int(1) NOT NULL,
  ADD COLUMN `device_session_googleplus` int(1) NOT NULL,

  ADD COLUMN `device_gyro_alpha` float(3,2) NOT NULL,
  ADD COLUMN `device_gyro_beta` float(3,2) NOT NULL,
  ADD COLUMN `device_gyro_gamma` float(3,2) NOT NULL,
  ADD COLUMN `device_gyro_qc`  int(1) NOT NULL,

  ADD COLUMN `device_dev_tool` int(1) NOT NULL;

 */
