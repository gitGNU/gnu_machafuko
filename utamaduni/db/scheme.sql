create table if not exists core_user (
	id int(6) auto_increment,
	email varchar(100) not null,
	pass varchar(100) not null,
	name varchar(50) not null,
	lname varchar(100),
	constraint pk_user primary key (id),
	constraint un_user unique (email)
) engine=innodb, charset=utf8;


create table if not exists utam_publisher (
	id int(7) auto_increment,
	name varchar(50) not null,
	constraint pk_publisher primary key (id),
	constraint un_publisher unique (name)
) engine=innodb, charset=utf8;


create table if not exists utam_format (
	id int(7) auto_increment,
	name varchar(50) not null,
	constraint pk_publisher primary key (id),
	constraint un_publisher unique (name)
) engine=innodb, charset=utf8;


create table if not exists utam_book (
       id int(6) auto_increment,
       isbn varchar(30) not null,
       title varchar(100) not null,
       description varchar(500),
       cover varchar(200),
       publisher int(7),
       format int(7),
       pages int(4),
       constraint pk_book primary key (id),
       constraint un_book unique (isbn),
       constraint fk_book_publisher foreign key (publisher) references utam_publisher(id) on delete set null on update cascade,
       constraint fk_book_format foreign key (format) references utam_format(id) on delete set null on update cascade
) engine=innodb, charset=utf8;


create table if not exists utam_author (
       id int(6) auto_increment,
       name varchar(30) not null,
       surname varchar(50) not null,
       photo varchar(200),
       constraint pk_author primary key (id),
       constraint un_author unique (name, surname)
) engine=innodb, charset=utf8;


create table if not exists utam_book_author (
       id int(7) auto_increment,
       book int(6) not null,	-- primary key of utam_book table.
       author int(6) not null,	-- primary key of utam_author table.
       constraint pk_book_author primary key (id),
       constraint un_book_author unique (book, author),
       constraint fk_book_author_book foreign key (book) references utam_book(id) on delete cascade on update cascade,
       constraint fk_book_author_author foreign key (author) references utam_author(id) on delete cascade on update cascade
) engine=innodb, charset=utf8;


create table if not exists utam_subject (
       id int(2) auto_increment,
       name varchar(100) not null,
       constraint pk_subject primary key (id),
       constraint un_subject unique (name)
) engine=innodb, charset=utf8;


create table if not exists utam_book_subject (
       id int(7) auto_increment,
       book int(6) not null,	-- primary key of utam_book table.
       subject int(6) not null,	-- primary key of utam_subject table.
       constraint pk_book_subject primary key (id),
       constraint un_book_subject unique (book, subject),
       constraint fk_book_subject_book foreign key (book) references utam_book(id) on delete cascade on update cascade,
       constraint fk_book_subject_subject foreign key (subject) references utam_subject(id) on delete cascade on update cascade
) engine=innodb, charset=utf8;


create table if not exists utam_read (
       id int(6) auto_increment,
       isbn varchar(30) not null,
       start date,			-- started read date.
       finish date,			-- finished read date.
       opinion varchar(500),		-- my personal opinion about this read book.
       valoration int(2),		-- my personal valoration (1 - 10).
       constraint pk_read primary key (id),
       constraint un_read unique (isbn),
       constraint fk_read_book foreign key (id) references utam_book(id) on delete cascade on update cascade
) engine=innodb, charset=utf8;


create table if not exists utam_wishlist (
       id int(6) auto_increment,
       isbn varchar(30) not null,
       constraint pk_wishlist primary key (id),
       constraint un_wishlist unique (isbn),
       constraint fk_wishlist_book foreign key (id) references utam_book(id) on delete cascade on update cascade
) engine=innodb, charset=utf8;


create table if not exists ajen_street (
       id int(7) auto_increment,
       name varchar(100) not null,
       num varchar(4),
       extra varchar(100),
       constraint pk_street primary key (id)
) engine=innodb, charset=utf8;

create table if not exists ajen_address (
       id int(7) auto_increment,
       street int(7) not null,
       city varchar(100) not null,
       country varchar(100) not null,
       constraint pk_address primary key (id),
       constraint fk_address_street foreign key (street) references ajen_street(id) on delete set null on update cascade
) engine=innodb, charset=utf8;


create table if not exists utam_bookshop (
       id int(6) auto_increment,
       name varchar(100),
       address int(7),
       logo varchar(200),
       constraint pk_bookshop primary key (id),
       constraint fk_bookshop_address foreign key (address) references ajen_address(id) on delete set null on update cascade
) engine=innodb, charset=utf8;


create table if not exists utam_purchased (
       id int(6) auto_increment,
       isbn varchar (30) not null,
       price float not null, -- price in Euros.
       bookshop int(6),
       constraint pk_purchased primary key (id),
       constraint un_purchased unique (isbn),
       constraint fk_purchased_read foreign key (id) references utam_read(id) on delete cascade on update cascade,
       constraint fk_purchased_bookshop foreign key (bookshop) references utam_bookshop(id) on delete set null on update cascade
) engine=innodb, charset=utf8;


create table if not exists ajen_contact (
       id int(6) auto_increment,
       name varchar(30) not null,
       surname varchar(50),
       nick varchar(30),
       address varchar(300),
       birthday date,
       constraint pk_contact primary key (id)
) engine=innodb, charset=utf8;


create table if not exists utam_loaned (
       id int(6) auto_increment,
       isbn varchar (30) not null,
       contact int(6) not null,		-- Contact identifier.
       constraint pk_loaned primary key (id),
       constraint un_loaned unique (isbn),
       constraint fk_loaned_read foreign key (id) references utam_read(id) on delete cascade on update cascade,
       constraint fk_loaned_contact foreign key (contact) references ajen_contact(id) on delete cascade on update cascade
) engine=innodb, charset=utf8;


create table if not exists utam_quote (
       id int(6) auto_increment,
       quote varchar(1000) not null,
       author varchar(200),
       constraint pk_quote primary key (id)
) engine=innodb, charset=utf8;


create table if not exists utam_book_quote (
       id int(6) auto_increment,
       page int(3),
       book int(6) not null,	-- Book readed identifier where is the quote.
       constraint pk_book_quote primary key (id),
       constraint fk_book_quote_quote foreign key (id) references utam_quote(id) on delete cascade on update cascade,
       constraint fk_book_quote_book foreign key (book) references utam_read(id) on delete cascade on update cascade
) engine=innodb, charset=utf8;


create table if not exists ajen_tag (
       id int(6) auto_increment,
       name varchar(50) not null,
       constraint pk_tag primary key (id),
       constraint un_tag unique (name)
) engine=innodb, charset=utf8;


create table if not exists ajen_contact_tag (
       id int(6) auto_increment,
       contact int(6), -- Contact primary key references.
       tag int(6),     -- Tag primary key references.
       constraint pk_contact_tag primary key (id),
       constraint un_contact_tag unique (contact, tag),
       constraint fk_contact_tag_contact foreign key (contact) references ajen_contact(id) on delete cascade on update cascade,
       constraint fk_contact_tag_tag foreign key (tag) references ajen_tag(id) on delete cascade on update cascade
) engine=innodb, charset=utf8;


create table if not exists ajen_email (
       id int(7) auto_increment,
       email varchar(200) not null,
       contact int(6) not null,		-- Contact primary key references.
       constraint pk_email primary key (id),
       constraint fk_email_contact foreign key (contact) references ajen_contact(id) on delete cascade on update cascade
) engine=innodb, charset=utf8;


create table if not exists ajen_phone (
       id int(7) auto_increment,
       numphone varchar(50) not null,
       contact int(6) not null,		-- Contact primary key references.
       constraint pk_phone primary key (id),
       constraint fk_phone_contact foreign key (contact) references ajen_contact(id) on delete cascade on update cascade
) engine=innodb, charset=utf8;
