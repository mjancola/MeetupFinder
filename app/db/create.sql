
use meetupfinder_prod;
drop table if exists users;
CREATE TABLE users (name VARCHAR(254), email VARCHAR(254), claimed_id VARCHAR(254), facebook_token VARCHAR(254), facebooke_expires INT, linkedin_token VARCHAR(254), linkedin_expires INT, foursquare_token VARCHAR(254), foursquare_expires INT, PRIMARY KEY (claimed_id)); 
INSERT INTO users VALUES ( "Mike", "momo@me.com", "f8rj49f", "123456789", 123, "123456789", 123, "123456789", 123 ), ( "Sashank", "sas@hank.com", "jr9bkt", "923456789", 923, "923456789", 923, "923456789", 923 );
