
use meetupfinder_2;
drop table if exists users;
CREATE TABLE users (name VARCHAR(254), email VARCHAR(254), claimed_id VARCHAR(254), facebook_token VARCHAR(254), facebook_expires INT UNSIGNED DEFAULT 0, linkedin_token VARCHAR(254), linkedin_expires INT UNSIGNED DEFAULT 0, foursquare_token VARCHAR(254), foursquare_expires INT UNSIGNED DEFAULT 0, PRIMARY KEY (claimed_id)); 
INSERT INTO users VALUES ( "Mike", "momo@me.com", "f8rj49f", "123456789", 1380218952, "123456789", 4000000000, "123456789", 30 );
