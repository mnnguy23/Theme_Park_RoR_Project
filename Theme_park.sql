/*-------------------------------Tables-------------------------------*/
CREATE TABLE public.department
(
    dname character varying(15) COLLATE pg_catalog."default" NOT NULL,
    dnumber integer NOT NULL,
    mgr_ssn character(9) COLLATE pg_catalog."default" NOT NULL,
    mgr_start_date date,
    CONSTRAINT department_pkey PRIMARY KEY (dnumber),
    CONSTRAINT department_dname_key UNIQUE (dname)
)

CREATE TABLE public.employee
(
    name character varying(50) COLLATE pg_catalog."default" NOT NULL,
    ssn integer NOT NULL,
    super_ssn integer,
    employee_id integer NOT NULL,
    bdate date,
    startdate date NOT NULL,
    address character varying(50) COLLATE pg_catalog."default" NOT NULL,
    sex character(1) COLLATE pg_catalog."default" NOT NULL DEFAULT NULL::bpchar,
    salary numeric(10, 2) NOT NULL DEFAULT NULL::numeric,
    dno integer NOT NULL,
    phone_number character(12) COLLATE pg_catalog."default" NOT NULL,
    employee_username character varying(20) COLLATE pg_catalog."default" NOT NULL,
    employee_password character varying(20) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT employee_pkey PRIMARY KEY (ssn),
    CONSTRAINT employee_employee_id_key UNIQUE (employee_id),
    CONSTRAINT employee_employee_password_key UNIQUE (employee_password),
    CONSTRAINT employee_employee_username_key UNIQUE (employee_username),
    CONSTRAINT employee_phone_number_key UNIQUE (phone_number),
    CONSTRAINT employee_ibfk_1 FOREIGN KEY (super_ssn)
        REFERENCES public.employee (ssn) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT employee_ibfk_2 FOREIGN KEY (dno)
        REFERENCES public.department (dnumber) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT minvalid_ssn CHECK (ssn >= 111111111),
    CONSTRAINT maxvalid_ssn CHECK (ssn <= 999999999),
    CONSTRAINT minvalid_id CHECK (employee_id >= 1111111),
    CONSTRAINT maxvalid_id CHECK (employee_id <= 9999999)
)

CREATE TABLE public.game
(
    prize gprize NOT NULL,
    price integer NOT NULL,
    game_id integer NOT NULL,
    maint_date date,
    gname character varying(15) COLLATE pg_catalog."default" NOT NULL,
    capacity integer NOT NULL,
    dno integer,
    CONSTRAINT game_pkey PRIMARY KEY (game_id),
    CONSTRAINT game_gname_key UNIQUE (gname),
    CONSTRAINT game_ibfk_1 FOREIGN KEY (dno)
        REFERENCES public.department (dnumber) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

CREATE TABLE public.kiosk
(
    kiosk_id integer NOT NULL,
    service_type stype NOT NULL,
    price integer NOT NULL,
    name character(25) COLLATE pg_catalog."default" NOT NULL,
    dno integer,
    CONSTRAINT kiosk_pkey PRIMARY KEY (kiosk_id),
    CONSTRAINT kiosk_name_key UNIQUE (name),
    CONSTRAINT kiosk_ibfk_1 FOREIGN KEY (dno)
        REFERENCES public.department (dnumber) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

CREATE TABLE public.attraction
(
    ride_id integer NOT NULL,
    price integer NOT NULL,
    capacity integer NOT NULL,
    date_built date,
    maintenance_date date,
    name character(30) COLLATE pg_catalog."default" NOT NULL,
    rider_count integer,
    rider_time timestamp without time zone NOT NULL DEFAULT now(),
    dno integer,
    maintaince_cost integer NOT NULL,
    operation_cost integer NOT NULL,
    CONSTRAINT ride_pkey PRIMARY KEY (ride_id),
    CONSTRAINT ride_ibfk_1 FOREIGN KEY (dno)
        REFERENCES public.department (dnumber) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

CREATE TABLE public.ticket
(
    ticket_id integer NOT NULL,
    price integer NOT NULL,
    ticket_type t_type,
    CONSTRAINT ticket_pkey PRIMARY KEY (ticket_id)
)

CREATE TABLE public.merchandise
(
    product character varying(25) COLLATE pg_catalog."default" NOT NULL,
    inventory integer NOT NULL,
    sold integer NOT NULL,
    units_sold_weekly integer NOT NULL,
    serial_number integer NOT NULL,
    CONSTRAINT merchandise_serial_number_key UNIQUE (serial_number),
    CONSTRAINT max_inventory CHECK (inventory <= 1000)
)

/*-------------------------------TRIGGERS-------------------------------*/
CREATE OR REPLACE FUNCTION update_changetimestamp_column()
RETURNS TRIGGER AS $$
BEGIN
   NEW.changetimestamp = now(); 
   RETURN NEW;
END;
$$ language 'plpgsql';

/*-------------------------------ENUMS-------------------------------*/
CREATE TYPE public.gprize AS ENUM
    ('small', 'medium', 'large');

CREATE TYPE public.stype AS ENUM
    ('food', 'gifts');

CREATE TYPE public.t_type AS ENUM
    ('season', 'regular');
    
/*-------------------------------Altering-------------------------------*/
ALTER TABLE employee ADD startdate date;
ALTER TABLE ride ALTER COLUMN rider_time SET NOT null;

/*-------------------------------Inserting-------------------------------*/
VALUES
('Michael Nguyen', 123456789, null, 1111111, '1995-02-16', '2012-12-9', '1111 Some Rd.', 'M', 120000, 1, 7137654321, 'user', 'password'),
('Joshua Pham', 987654321, null, 1111112, '1994-4-21', '2012-12-9', '2222 Some Rd.', 'M', 100000, 2, 7139845261, 'user1', 'password1'),
('Etienne Pierre', 123987654, 123456789, 1111113, '1995-4-7', '2012-12-9', '3333 Some Rd.', 'M', 55500, 1, 3847592749, 'user2', 'password2'),
('Jose Perez', 963852741, null, 1111114, '1994-4-21', '2012-12-9', '4444 SomeRd.', 'M', 95000, 4, 8321654189, 'user3', 'password3'),
('Carlos Puerta', 852741963, null, 1111115, '1993-7-15', '2012-12-9', '5555 Some Rd.', 'M', 100000, 3, 2817654321, 'user4', 'password4'),
('John Dough', 546498453, 987654321, 1111116, '1989-5-31', '2014-2-5', '5644 Bellaire', 'M', 58000, 2, 7134568149, 'user5', 'password5'),
('Jill Smith', 456194651, 852741963, 1111117, '1984-5-14', '2013-8-19', '1234 Beechnut', 'F', 45000, 3, 2845685142, 'user6', 'password6'),
('Samantha Luu', 215612315, 963852741, 1111118, '1987-6-07', '2015-4-8', '54127 Calhoun Rd.', 'F', 32000, 4, 8324562158, 'user7', 'password7'),
('Andrea Black', 848741334, 123456789, 1111119, '1975-9-16', '2014-6-14', '14578 Rose Dr.', 'F', 47000, 1, 2156548946, 'user8', 'password8'),
('Tiffany White', 351455844, 987654321, 1111120, '1978-3-04', '2015-12-15', '32145 None Cir.', 'F', 43000, 2, 8321564895, 'user9', 'password9'),
('Rachel Long', 741254894, 852741963, 1111121, '1985-1-09', '2016-12-19', '12345 Some St.', 'F', 43000, 3, 8321556498, 'user10', 'password10'),
('Jennifer Walker', 489413895, 963852741, 1111122, '1986-2-26', '2013-7-25', '45612 Main St.', 'F', 35000, 4, 5149456123, 'user11', 'password11');

INSERT INTO merchandise
VALUES
('Plushies', 350, 75748, 275, 0000001),
('Tumblers', 750, 15000, 487, 0000002),
('Shirts', 650, 15000, 564, 0000003),
('Hats', 650, 15000, 578, 0000004),
('Coloring Books', 300, 15000, 147, 0000005),
('Sunglasses', 200, 15000, 78, 0000006),
('Toys', 500, 15000, 324, 0000007),
('Backpacks', 350, 25412, 158, 0000008),
('Magnets', 1000, 112340, 754, 0000009),
('Keychains', 1000, 123456, 684, 0000010);
>>>>>>> origin/master
