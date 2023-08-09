create database geomais;

create table sex(
 	id integer not null primary key,
 	name character varying(20)
);

create sequence iperson;

create table person
(
	id integer not null primary key default nextval('iperson'::regclass),
	name character varying(100),
	cpf character varying(11),
	rg character varying(11),
	birth_date timestamp,
	sex_id integer,
	created_at timestamp,
	update_at timestamp,
	constraint sex_foreign_key foreign key (sex_id) references sex(id)
);
