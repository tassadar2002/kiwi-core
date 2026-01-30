create table element
(
    id         int primary key auto_increment,
    name       varchar(50),
    parent     varchar(50),
    title      varchar(100),
    subtitle   varchar(1000),
    image      varchar(100),
    attribute  varchar(200),
    link       varchar(1000),
    `order`    int       default 0,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp,
    index (parent),
    index ( name)
);

create table config
(
    id          int primary key auto_increment,
    name        varchar(50) not null,
    `value`     text,
    type        varchar(10),
    description varchar(100),
    created_at  timestamp default current_timestamp,
    updated_at  timestamp default current_timestamp on update current_timestamp,
    unique (name)
);

create table admin
(
    id             int primary key auto_increment,
    email          varchar(100) not null,
    password       varchar(255) not null,
    description    varchar(1000),
    remember_token varchar(100),
    role           varchar(20)  not null,
    created_at     timestamp default current_timestamp,
    updated_at     timestamp default current_timestamp on update current_timestamp,
    unique (email)
);