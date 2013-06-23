REM create database meetupfinder;

use meetupfinder;
drop table if exists users;
CREATE TABLE users (name VARCHAR(254), facebook_token VARCHAR(254), facebooke_expires INT, linkedin_token VARCHAR(254), linkedin_expires INT, foursquare_token VARCHAR(254), foursquare_expires INT); 
INSERT INTO users VALUES ( "Mike", "123456789", 123, "123456789", 123, "123456789", 123 ), ( "Sashank", "923456789", 923, "923456789", 923, "923456789", 923 );
