create table if not exists Resource (
       id int auto_increment,
       uri varchar(200) not null,
       name varchar(100) not null,
       description varchar(200),
       created date,
       privacy int(1) default 0, -- 0=private, 1=public
       constraint pk_resource primary key (id)
) engine=innodb, charset=utf8;


create table if not exists WebAccount (
       id int auto_increment,
       username varchar(128) not null,
       email varchar(128) not null,
       password varchar(128) not null,
       constraint pk_webaccount primary key (id),
       constraint un_webaccount1 unique (username),
       constraint un_webaccount2 unique (email)
) engine=innodb, charset=utf8;


create table if not exists Web (
       id int auto_increment,
       logo varchar(200),
       account int,
       constraint pk_web primary key (id),
       constraint un_web unique (account),
       constraint fk_web_resource foreign key (id) references Resource (id) on delete cascade on update cascade,
       constraint fk_web_webaccount foreign key (account) references WebAccount (id) on delete cascade on update cascade
) engine=innodb, charset=utf8;


create table if not exists Document (
       id int auto_increment,
       extension varchar(10) not null,
       mimeType varchar(100) not null,
       constraint pk_document primary key (id),
       constraint fk_document_resource foreign key (id) references Resource (id) on delete cascade on update cascade
) engine=innodb, charset=utf8;


create table if not exists Tag (
       id int auto_increment,
       name varchar(50) not null,
       constraint pk_tag primary key (id),
       constraint un_tag unique (name)
) engine=innodb, charset=utf8;


create table if not exists TagResource (
       id int auto_increment,
       res int not null,
       tag int not null,
       constraint pk_tagresource primary key (id),
       constraint un_tagresource unique (res, tag),
       constraint fk_tagresource_resource foreign key (res) references Resource (id) on delete cascade on update cascade,
       constraint fk_tagresource_tag foreign key (tag) references Tag (id) on delete cascade on update cascade
) engine=innodb, charset=utf8;


create table if not exists User (
       id int auto_increment,
       username varchar(128) not null,
       email varchar(128) not null,
       password varchar(128) not null,
       constraint pk_webaccount primary key (id),
       constraint un_user1 unique (username),
       constraint un_user2 unique (email)
) engine=innodb, charset=utf8;


create table if not exists UserResource (
       id int auto_increment,
       res int not null,
       user int not null,
       constraint pk_userresource primary key (id),
       constraint un_userresource unique (res, user),
       constraint fk_userresource_resource foreign key (res) references Resource (id) on delete cascade on update cascade,
       constraint fk_userresource_user foreign key (user) references User (id) on delete cascade on update cascade
) engine=innodb, charset=utf8;


create table if not exists Valoration (
       id int auto_increment,
       votes int not null, -- number of people who have voted.
       total int not null, -- add.
       constraint pk_valoration primary key (id)
) engine=innodb, charset=utf8;


create table if not exists ResourceValoration (
       id int auto_increment,
       res int not null,
       val int not null,
       constraint pk_resourcevaloration primary key (id),
       constraint fk_resourcevaloration_resource foreign key (res) references Resource (id) on delete cascade on update cascade,
       constraint fk_resourcevaloration_valoration foreign key (val) references Valoration (id) on delete cascade on update cascade
) engine=innodb, charset=utf8;


create table if not exists Comment (
       id int auto_increment,
       comment varchar(500) not null,
       constraint pk_comment primary key (id)
) engine=innodb, charset=utf8;


create table if not exists UserComment (
       id int auto_increment,
       comment int not null,
       user int not null,
       constraint pk_usercomment primary key (id),
       constraint fk_usercomment_comment foreign key (comment) references Comment (id) on delete cascade on update cascade,
       constraint fk_usercomment_user foreign key (user) references User (id) on delete cascade on update cascade
) engine=innodb, charset=utf8;
