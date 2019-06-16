drop table if exists users cascade;
drop table if exists restaurants cascade;
drop table if exists voting cascade;
drop table if exists adminkeys cascade;

create table users (
	username        varchar(50)  primary key,
	password        varchar(50)  not null,
    first_name      varchar(50),
    last_name       varchar(50),
    email           varchar(50),
    account_type    varchar(6)   not null,
    check (account_type = 'voter' or account_type = 'admin')
);

create table restaurants (
    restaurant_name varchar(50)  primary key,
    elo             float      not null
);

create table voting (
    username        varchar(50)  references users(username),
    restaurantGood  varchar(50)  references restaurants(restaurant_name),
    restaurantBad   varchar(50)  references restaurants(restaurant_name)
);

create table adminkeys (
    aKey        varchar(50)  primary key,
    key_owner       varchar(50)  references users(username) ON DELETE CASCADE
);

-- username: auser          password: apassword
insert into users (username, password, first_name, last_name, email, account_type) values ('auser', 'e7c551f0a6db74418dfe7e1b0240d422167fc51c', 'afirstname', 'alastname', 'a@ema.il', 'admin');

-- admin key: akey          owner: auser
insert into adminkeys (aKey, key_owner) values ('010c829765cc477f62eda8ffd58ef73c4a1f0b5f', 'auser');

insert into restaurants (restaurant_name, elo) values ('Amaya Express',1500);
insert into restaurants (restaurant_name, elo) values ('A&W',1500);
insert into restaurants (restaurant_name, elo) values ('Baton Rouge ',1500);
insert into restaurants (restaurant_name, elo) values ('Booster Juice',1500);
insert into restaurants (restaurant_name, elo) values ('Boston Pizza',1500);
insert into restaurants (restaurant_name, elo) values ('Burger King',1500);
insert into restaurants (restaurant_name, elo) values ('Chipotle Mexican Grill',1500);
insert into restaurants (restaurant_name, elo) values ('Cinnabon',1500);
insert into restaurants (restaurant_name, elo) values ('Coffee Time',1500);
insert into restaurants (restaurant_name, elo) values ('Cora',1500);
insert into restaurants (restaurant_name, elo) values ('Country Style',1500);
insert into restaurants (restaurant_name, elo) values ('Cows Ice Cream',1500);
insert into restaurants (restaurant_name, elo) values ('Dairy Queen',1500);
insert into restaurants (restaurant_name, elo) values ('East Side Mario''s',1500);
insert into restaurants (restaurant_name, elo) values ('Edo Japan',1500);
insert into restaurants (restaurant_name, elo) values ('Extreme Pita',1500);
insert into restaurants (restaurant_name, elo) values ('Five Guys',1500);
insert into restaurants (restaurant_name, elo) values ('Freshii',1500);
insert into restaurants (restaurant_name, elo) values ('Goji''s',1500);
insert into restaurants (restaurant_name, elo) values ('Harvey''s',1500);
insert into restaurants (restaurant_name, elo) values ('Hero Certified Burgers',1500);
insert into restaurants (restaurant_name, elo) values ('Jack Astor''s Bar and Grill',1500);
insert into restaurants (restaurant_name, elo) values ('Jimmy the Greek',1500);
insert into restaurants (restaurant_name, elo) values ('JOEY',1500);
insert into restaurants (restaurant_name, elo) values ('Kelsey''s Neighbourhood Bar & Grill',1500);
insert into restaurants (restaurant_name, elo) values ('KFC',1500);
insert into restaurants (restaurant_name, elo) values ('Krispy Kreme',1500);
insert into restaurants (restaurant_name, elo) values ('Manchu Wok',1500);
insert into restaurants (restaurant_name, elo) values ('Mandarin Restaurant',1500);
insert into restaurants (restaurant_name, elo) values ('McDonald''s',1500);
insert into restaurants (restaurant_name, elo) values ('Milestones Grill and Bar',1500);
insert into restaurants (restaurant_name, elo) values ('Montana''s Cookhouse',1500);
insert into restaurants (restaurant_name, elo) values ('Moxie''s Grill & Bar',1500);
insert into restaurants (restaurant_name, elo) values ('Mr. Greek',1500);
insert into restaurants (restaurant_name, elo) values ('Mr. Sub',1500);
insert into restaurants (restaurant_name, elo) values ('New York Fries',1500);
insert into restaurants (restaurant_name, elo) values ('Orange Julius',1500);
insert into restaurants (restaurant_name, elo) values ('Pickle Barrel',1500);
insert into restaurants (restaurant_name, elo) values ('Pita Pit',1500);
insert into restaurants (restaurant_name, elo) values ('Pizza Pizza',1500);
insert into restaurants (restaurant_name, elo) values ('Popeyes',1500);
insert into restaurants (restaurant_name, elo) values ('Quiznos',1500);
insert into restaurants (restaurant_name, elo) values ('Richtree Market',1500);
insert into restaurants (restaurant_name, elo) values ('Second Cup',1500);
insert into restaurants (restaurant_name, elo) values ('Shanghai 360',1500);
insert into restaurants (restaurant_name, elo) values ('Smoke''s Poutinerie',1500);
insert into restaurants (restaurant_name, elo) values ('Subway',1500);
insert into restaurants (restaurant_name, elo) values ('Swiss Chalet',1500);
insert into restaurants (restaurant_name, elo) values ('Taco Bell',1500);
insert into restaurants (restaurant_name, elo) values ('Ten-Ren',1500);
insert into restaurants (restaurant_name, elo) values ('Thaï Express',1500);
insert into restaurants (restaurant_name, elo) values ('The Keg',1500);
insert into restaurants (restaurant_name, elo) values ('The Old Spaghetti Factory',1500);
insert into restaurants (restaurant_name, elo) values ('The Works',1500);
insert into restaurants (restaurant_name, elo) values ('Tim Hortons',1500);
insert into restaurants (restaurant_name, elo) values ('Vanelli''s',1500);
insert into restaurants (restaurant_name, elo) values ('Wendy''s',1500);
insert into restaurants (restaurant_name, elo) values ('Wild Wing Restaurants',1500);
insert into restaurants (restaurant_name, elo) values ('Wimpy''s Diner',1500);
insert into restaurants (restaurant_name, elo) values ('Yogen Früz',1500);
