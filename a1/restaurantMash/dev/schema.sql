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
    rId             integer      not null   unique,
    elo             integer      not null,
    blurb           varchar(140)
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
insert into adminkeys (aKey, key_owner) values ('70b70d58af3c82bd289d58bd59ea48a1982168ac', 'auser');

insert into restaurants('Amaya Express',0,0);
insert into restaurants('A&W',0,0);
insert into restaurants('Baton Rouge ',0,0);
insert into restaurants('Booster Juice',0,0);
insert into restaurants('Boston Pizza',0,0);
insert into restaurants('Burger King',0,0);
insert into restaurants('Chipotle Mexican Grill',0,0);
insert into restaurants('Cinnabon',0,0);
insert into restaurants('Coffee Time',0,0);
insert into restaurants('Cora',0,0);
insert into restaurants('Country Style',0,0);
insert into restaurants('Cows Ice Cream',0,0);
insert into restaurants('Dairy Queen',0,0);
insert into restaurants('East Side Mario''s',0,0);
insert into restaurants('Edo Japan',0,0);
insert into restaurants('Extreme Pita',0,0);
insert into restaurants('Five Guys',0,0);
insert into restaurants('Freshii',0,0);
insert into restaurants('Goji\'s',0,0);
insert into restaurants('Harvey''s',0,0);
insert into restaurants('Hero Certified Burgers',0,0);
insert into restaurants('Jack Astor''s Bar and Grill',0,0);
insert into restaurants('Jimmy the Greek',0,0);
insert into restaurants('JOEY',0,0);
insert into restaurants('Kelsey''s Neighbourhood Bar & Grill',0,0);
insert into restaurants('KFC',0,0);
insert into restaurants('Krispy Kreme',0,0);
insert into restaurants('Manchu Wok',0,0);
insert into restaurants('Mandarin Restaurant',0,0);
insert into restaurants('McDonald''s',0,0);
insert into restaurants('Milestones Grill and Bar',0,0);
insert into restaurants('Montana''s Cookhouse',0,0);
insert into restaurants('Moxie''s Grill & Bar',0,0);
insert into restaurants('Mr. Greek',0,0);
insert into restaurants('Mr. Sub',0,0);
insert into restaurants('New York Fries',0,0);
insert into restaurants('Orange Julius',0,0);
insert into restaurants('Pickle Barrel',0,0);
insert into restaurants('Pita Pit',0,0);
insert into restaurants('Pizza Pizza',0,0);
insert into restaurants('Popeyes',0,0);
insert into restaurants('Quiznos',0,0);
insert into restaurants('Richtree Market',0,0);
insert into restaurants('Second Cup',0,0);
insert into restaurants('Shanghai 360',0,0);
insert into restaurants('Smoke''s Poutinerie',0,0);
insert into restaurants('Subway',0,0);
insert into restaurants('Swiss Chalet',0,0);
insert into restaurants('Taco Bell',0,0);
insert into restaurants('Ten-Ren',0,0);
insert into restaurants('Thaï Express',0,0);
insert into restaurants('The Keg',0,0);
insert into restaurants('The Old Spaghetti Factory',0,0);
insert into restaurants('The Works',0,0);
insert into restaurants('Tim Hortons',0,0);
insert into restaurants('Vanelli''s',0,0);
insert into restaurants('Wendy''s',0,0);
insert into restaurants('Wild Wing Restaurants',0,0);
insert into restaurants('Wimpy''s Diner',0,0);
insert into restaurants('Yogen Früz',0,0);
