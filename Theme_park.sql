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
    fname character varying(15) COLLATE pg_catalog."default" NOT NULL,
    lname character varying(15) COLLATE pg_catalog."default" NOT NULL,
    ssn character(9) COLLATE pg_catalog."default" NOT NULL,
    bdate date,
    address character varying(30) COLLATE pg_catalog."default" DEFAULT NULL::character varying,
    sex character(1) COLLATE pg_catalog."default" DEFAULT NULL::bpchar,
    salary numeric(10, 2) DEFAULT NULL::numeric,
    super_ssn character(9) COLLATE pg_catalog."default" DEFAULT NULL::bpchar,
    dno integer NOT NULL,
    phone_number character(12) COLLATE pg_catalog."default" DEFAULT NULL::bpchar,
    employee_username character varying(20) COLLATE pg_catalog."default" NOT NULL,
    employee_password character varying(20) COLLATE pg_catalog."default" NOT NULL,
    startdate date NOT NULL,
    CONSTRAINT employee_pkey PRIMARY KEY (ssn),
    CONSTRAINT employee_ibfk_1 FOREIGN KEY (super_ssn)
        REFERENCES public.employee (ssn) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT employee_ibfk_2 FOREIGN KEY (dno)
        REFERENCES public.department (dnumber) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
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
INSERT INTO employee
VALUES
('Jose', 'Perez', 963852741, '1994-4-21', '4444 Road', 'M', 50000, 987654321, 1, 7137654321, 'user3', 'password3'),
('Carlos', 'Puerta', 852741963, '1993-7-15', '5555 Road', 'M', 55000, 987654321, 1, 2817654321, 'user4', 'password4'),
('John', 'Dough', 546498453, '1989-5-31', '5644 Bellaire', 'M', 58000, 123456789, 1, 7134568149, 'user4', 'password4', '2014-2-5'),
('Jill', 'Smith', 456194651, '1984-5-14', '1234 Beechnut', 'F', 45000, 123456789, 1, 2845685142, 'user5', 'password5', '2013-8-19'),
('Samantha', 'Luu', 215612315, '1987-6-07', '54127 Calhoun Rd.', 'F', 32000, 852741963, 1, 8324562158, 'user6', 'password6', '2015-4-8'),
('Andrea', 'Black', 848741334, '1975-9-16', '14578 Rose Dr.', 'F', 47000, 963852741, 1, 2156548946, 'user7', 'password7', '2014-6-14'),
('Tiffany', 'White', 351455844, '1978-3-04', '32145 None Cir.', 'F', 43000, 123456789, 1, 8321564895, 'user8', 'password8', '2015-12-15'),
('Jennifer', 'Walker', 489413895, '1986-2-26', '45612 Main St.', 'F', 35000, 963852741, 1, 5149456123, 'user9', 'password9', '2013-7-25');

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
