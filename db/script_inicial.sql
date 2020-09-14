--
-- PostgreSQL database dump
--

-- Dumped from database version 10.12 (Ubuntu 10.12-0ubuntu0.18.04.1)
-- Dumped by pg_dump version 10.12 (Ubuntu 10.12-0ubuntu0.18.04.1)

-- Started on 2020-09-14 12:32:18 -03

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 9 (class 2615 OID 31073)
-- Name: ordenes_trabajo; Type: SCHEMA; Schema: -; Owner: demo
--

CREATE SCHEMA ordenes_trabajo;


ALTER SCHEMA ordenes_trabajo OWNER TO demo;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 203 (class 1259 OID 31161)
-- Name: archivo; Type: TABLE; Schema: ordenes_trabajo; Owner: demo
--

CREATE TABLE ordenes_trabajo.archivo (
    id_archivo uuid DEFAULT ordenes_trabajo.gen_random_uuid() NOT NULL,
    nombre character varying(100) NOT NULL,
    descripcion character varying(500),
    path character varying(500) NOT NULL,
    fecha_creacion timestamp without time zone NOT NULL,
    extension character varying(5) NOT NULL,
    tamanio integer NOT NULL,
    borrado boolean DEFAULT false NOT NULL,
    id_ordenes_trabajo uuid NOT NULL
);


ALTER TABLE ordenes_trabajo.archivo OWNER TO demo;

--
-- TOC entry 200 (class 1259 OID 31141)
-- Name: estado; Type: TABLE; Schema: ordenes_trabajo; Owner: demo
--

CREATE TABLE ordenes_trabajo.estado (
    id_estado uuid DEFAULT ordenes_trabajo.gen_random_uuid() NOT NULL,
    descripcion character varying(255) NOT NULL
);


ALTER TABLE ordenes_trabajo.estado OWNER TO demo;

--
-- TOC entry 205 (class 1259 OID 31175)
-- Name: historial_estado_archivo; Type: TABLE; Schema: ordenes_trabajo; Owner: demo
--

CREATE TABLE ordenes_trabajo.historial_estado_archivo (
    id_historial_estado_archivo uuid DEFAULT ordenes_trabajo.gen_random_uuid() NOT NULL,
    id_historial_estado_orden_trabajo uuid NOT NULL,
    id_archivo uuid NOT NULL
);


ALTER TABLE ordenes_trabajo.historial_estado_archivo OWNER TO demo;

--
-- TOC entry 199 (class 1259 OID 31133)
-- Name: historial_estado_orden_trabajo; Type: TABLE; Schema: ordenes_trabajo; Owner: demo
--

CREATE TABLE ordenes_trabajo.historial_estado_orden_trabajo (
    id_historial_estado_orden_trabajo uuid DEFAULT ordenes_trabajo.gen_random_uuid() NOT NULL,
    id_estado uuid NOT NULL,
    id_usuario uuid,
    fecha_hora timestamp without time zone NOT NULL,
    observacion character varying(512),
    id_ordenes_trabajo uuid NOT NULL
);


ALTER TABLE ordenes_trabajo.historial_estado_orden_trabajo OWNER TO demo;

--
-- TOC entry 202 (class 1259 OID 31156)
-- Name: inmueble; Type: TABLE; Schema: ordenes_trabajo; Owner: demo
--

CREATE TABLE ordenes_trabajo.inmueble (
    id_inmueble uuid DEFAULT ordenes_trabajo.gen_random_uuid() NOT NULL,
    descripcion character varying(255),
    id_sucursal uuid
);


ALTER TABLE ordenes_trabajo.inmueble OWNER TO demo;

--
-- TOC entry 216 (class 1259 OID 31481)
-- Name: modificaciones_ot; Type: TABLE; Schema: ordenes_trabajo; Owner: demo
--

CREATE TABLE ordenes_trabajo.modificaciones_ot (
    id_modificacion uuid DEFAULT ordenes_trabajo.gen_random_uuid() NOT NULL,
    descripcion character varying(512),
    fecha_hora timestamp without time zone,
    id_ordenes_trabajo uuid
);


ALTER TABLE ordenes_trabajo.modificaciones_ot OWNER TO demo;

--
-- TOC entry 215 (class 1259 OID 31470)
-- Name: orden_anio_nro; Type: TABLE; Schema: ordenes_trabajo; Owner: demo
--

CREATE TABLE ordenes_trabajo.orden_anio_nro (
    id_orden_anio_nro uuid DEFAULT ordenes_trabajo.gen_random_uuid() NOT NULL,
    anio integer NOT NULL,
    numero integer NOT NULL
);


ALTER TABLE ordenes_trabajo.orden_anio_nro OWNER TO demo;

--
-- TOC entry 198 (class 1259 OID 31126)
-- Name: ordenes_trabajo; Type: TABLE; Schema: ordenes_trabajo; Owner: demo
--

CREATE TABLE ordenes_trabajo.ordenes_trabajo (
    id_ordenes_trabajo uuid DEFAULT ordenes_trabajo.gen_random_uuid() NOT NULL,
    nro_orden_trabajo character varying(50),
    fecha_hora_creacion timestamp without time zone,
    fecha_hora_finalizacion timestamp without time zone,
    descripcion text,
    id_historial_estado_orden_trabajo uuid,
    id_tipo_trabajo uuid,
    id_inmueble uuid,
    titulo character varying(100),
    id_usuario_crea uuid,
    fecha_hora_comienzo timestamp without time zone,
    id_usuario_asignado uuid
);


ALTER TABLE ordenes_trabajo.ordenes_trabajo OWNER TO demo;

--
-- TOC entry 208 (class 1259 OID 31322)
-- Name: persona; Type: TABLE; Schema: ordenes_trabajo; Owner: demo
--

CREATE TABLE ordenes_trabajo.persona (
    id_persona uuid DEFAULT ordenes_trabajo.gen_random_uuid() NOT NULL,
    apellido character varying(255),
    nombre character varying(255),
    id_sucursal uuid
);


ALTER TABLE ordenes_trabajo.persona OWNER TO demo;

--
-- TOC entry 209 (class 1259 OID 31335)
-- Name: sucursal; Type: TABLE; Schema: ordenes_trabajo; Owner: demo
--

CREATE TABLE ordenes_trabajo.sucursal (
    id_sucursal uuid DEFAULT ordenes_trabajo.gen_random_uuid() NOT NULL,
    descripcion character varying(255) NOT NULL
);


ALTER TABLE ordenes_trabajo.sucursal OWNER TO demo;

--
-- TOC entry 206 (class 1259 OID 31245)
-- Name: tipo_relacion; Type: TABLE; Schema: ordenes_trabajo; Owner: demo
--

CREATE TABLE ordenes_trabajo.tipo_relacion (
    id_tipo_relacion uuid DEFAULT ordenes_trabajo.gen_random_uuid() NOT NULL,
    descripcion character varying(255) NOT NULL
);


ALTER TABLE ordenes_trabajo.tipo_relacion OWNER TO demo;

--
-- TOC entry 201 (class 1259 OID 31151)
-- Name: tipo_trabajo; Type: TABLE; Schema: ordenes_trabajo; Owner: demo
--

CREATE TABLE ordenes_trabajo.tipo_trabajo (
    id_tipo_trabajo uuid DEFAULT ordenes_trabajo.gen_random_uuid() NOT NULL,
    descripcion character varying(255)
);


ALTER TABLE ordenes_trabajo.tipo_trabajo OWNER TO demo;

--
-- TOC entry 207 (class 1259 OID 31314)
-- Name: usuario; Type: TABLE; Schema: ordenes_trabajo; Owner: demo
--

CREATE TABLE ordenes_trabajo.usuario (
    id_usuario uuid DEFAULT ordenes_trabajo.gen_random_uuid() NOT NULL,
    id_persona uuid NOT NULL,
    descripcion character varying(255),
    username character varying(50) NOT NULL,
    password character varying(255) NOT NULL,
    tipo_usuario character varying(255),
    pwd_hash boolean
);


ALTER TABLE ordenes_trabajo.usuario OWNER TO demo;

--
-- TOC entry 204 (class 1259 OID 31170)
-- Name: usuario_orden_trabajo; Type: TABLE; Schema: ordenes_trabajo; Owner: demo
--

CREATE TABLE ordenes_trabajo.usuario_orden_trabajo (
    id_usuario_orden_trabajo uuid DEFAULT ordenes_trabajo.gen_random_uuid() NOT NULL,
    id_usuario uuid NOT NULL,
    id_ordenes_trabajo uuid NOT NULL
);


ALTER TABLE ordenes_trabajo.usuario_orden_trabajo OWNER TO demo;

--
-- TOC entry 214 (class 1259 OID 31452)
-- Name: auth_assignment; Type: TABLE; Schema: public; Owner: demo
--

CREATE TABLE public.auth_assignment (
    item_name character varying(64) NOT NULL,
    user_id character varying(64) NOT NULL,
    created_at integer
);


ALTER TABLE public.auth_assignment OWNER TO demo;

--
-- TOC entry 212 (class 1259 OID 31423)
-- Name: auth_item; Type: TABLE; Schema: public; Owner: demo
--

CREATE TABLE public.auth_item (
    name character varying(64) NOT NULL,
    type smallint NOT NULL,
    description text,
    rule_name character varying(64),
    data bytea,
    created_at integer,
    updated_at integer
);


ALTER TABLE public.auth_item OWNER TO demo;

--
-- TOC entry 213 (class 1259 OID 31437)
-- Name: auth_item_child; Type: TABLE; Schema: public; Owner: demo
--

CREATE TABLE public.auth_item_child (
    parent character varying(64) NOT NULL,
    child character varying(64) NOT NULL
);


ALTER TABLE public.auth_item_child OWNER TO demo;

--
-- TOC entry 211 (class 1259 OID 31415)
-- Name: auth_rule; Type: TABLE; Schema: public; Owner: demo
--

CREATE TABLE public.auth_rule (
    name character varying(64) NOT NULL,
    data bytea,
    created_at integer,
    updated_at integer
);


ALTER TABLE public.auth_rule OWNER TO demo;

--
-- TOC entry 210 (class 1259 OID 31410)
-- Name: migration; Type: TABLE; Schema: public; Owner: demo
--

CREATE TABLE public.migration (
    version character varying(180) NOT NULL,
    apply_time integer
);


ALTER TABLE public.migration OWNER TO demo;

--
-- TOC entry 3103 (class 0 OID 31161)
-- Dependencies: 203
-- Data for Name: archivo; Type: TABLE DATA; Schema: ordenes_trabajo; Owner: demo
--

INSERT INTO ordenes_trabajo.archivo VALUES ('adaede76-c1b4-4fb3-bce6-d719d07fefd6', 'archivo_adjunto_2', 'archivo nuevo', '/uploads/7f73c04c-8750-418e-9b32-de6b48554326/', '2020-09-13 23:43:41', 'jpg', 156571, false, '7f73c04c-8750-418e-9b32-de6b48554326');
INSERT INTO ordenes_trabajo.archivo VALUES ('c91b0149-ba63-4f60-9527-042362e9fbdd', 'archivo_adjunto_3', 'hala', '/uploads/7f73c04c-8750-418e-9b32-de6b48554326/', '2020-09-13 23:44:14', 'jpg', 128941, false, '7f73c04c-8750-418e-9b32-de6b48554326');
INSERT INTO ordenes_trabajo.archivo VALUES ('44bb18b7-2144-4726-a92a-df1c7638970f', 'archivo_adjunto_1', 'Foto de lugar', '/uploads/a2256f6d-3b73-4522-8fbe-6617e2b90a33/', '2020-09-14 08:23:59', 'jpg', 128941, false, 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.archivo VALUES ('c170e493-94d1-4c6d-bcda-ccf8c8dbf46a', 'archivo_adjunto_3', 'foto lugar borrar', '/uploads/a2256f6d-3b73-4522-8fbe-6617e2b90a33/', '2020-09-14 08:25:04', 'jpg', 156571, false, 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.archivo VALUES ('aabf4409-22e7-4a4e-925b-e366185709ba', 'archivo_adjunto_3', 'esto es el segundo archivo', '/uploads/7167302a-c59a-4c41-83c0-65906b1536f3/', '2020-09-14 11:06:29', 'jpg', 156571, false, '7167302a-c59a-4c41-83c0-65906b1536f3');
INSERT INTO ordenes_trabajo.archivo VALUES ('1eb02c6e-0125-4a2f-8e32-c69a6c6a4829', 'archivo_adjunto_1', 'rrr', '/uploads/7ac60382-db8e-4162-a203-c887f0e28bf1/', '2020-09-11 23:08:34', 'jpg', 128941, false, '7ac60382-db8e-4162-a203-c887f0e28bf1');
INSERT INTO ordenes_trabajo.archivo VALUES ('b08a2c16-7b4c-4fa6-aa0c-4283a3eeb1d1', 'archivo_adjunto_3', 'kkk', '/uploads/7ac60382-db8e-4162-a203-c887f0e28bf1/', '2020-09-11 23:18:33', 'jpg', 128941, false, '7ac60382-db8e-4162-a203-c887f0e28bf1');
INSERT INTO ordenes_trabajo.archivo VALUES ('af4aed37-51a7-4ff1-801c-1586ac330fe4', 'archivo_adjunto_2', 'a reparar', '/uploads/b35b8b26-0e07-4e9b-a948-d9131eb60a0d/', '2020-09-07 15:59:33', 'jpg', 156571, false, 'b35b8b26-0e07-4e9b-a948-d9131eb60a0d');
INSERT INTO ordenes_trabajo.archivo VALUES ('ec15d0f9-9a2e-4a15-b116-331e5d99e31f', 'archivo_adjunto_1', 'archivo muestra de trabajo', '/uploads/5a0c0ecf-92fe-47c5-a282-37d502a641c3/', '2020-09-12 00:29:30', 'jpg', 128941, false, '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.archivo VALUES ('35bd3440-741c-48c1-88b9-3a534ca86e43', 'archivo_adjunto_3', 'segunda muestra', '/uploads/52f57404-9fc9-477f-ba84-e166071898a6/', '2020-09-12 00:33:17', 'jpg', 156571, false, '52f57404-9fc9-477f-ba84-e166071898a6');
INSERT INTO ordenes_trabajo.archivo VALUES ('54f1341d-e1f8-4959-9214-15033aa0ddf5', 'archivo_adjunto_2', 'foto lugar 2', '/uploads/a2256f6d-3b73-4522-8fbe-6617e2b90a33/', '2020-09-14 08:24:24', 'jpg', 128941, false, 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.archivo VALUES ('56dedd81-f815-4959-bd70-ca0b8bc1fd8e', 'archivo_adjunto_4', 'esto es el segundo archivo', '/uploads/7167302a-c59a-4c41-83c0-65906b1536f3/', '2020-09-14 11:06:30', 'jpg', 156571, false, '7167302a-c59a-4c41-83c0-65906b1536f3');
INSERT INTO ordenes_trabajo.archivo VALUES ('f5c2f8e9-35cb-412e-8e4a-f04adb939742', 'archivo_adjunto_2', 'rrr', '/uploads/7ac60382-db8e-4162-a203-c887f0e28bf1/', '2020-09-11 23:08:34', 'jpg', 128941, false, '7ac60382-db8e-4162-a203-c887f0e28bf1');
INSERT INTO ordenes_trabajo.archivo VALUES ('0ad5e36d-b573-4523-ba81-9fe7b3b1c8d5', 'archivo_adjunto_4', 'kkk', '/uploads/7ac60382-db8e-4162-a203-c887f0e28bf1/', '2020-09-11 23:18:34', 'jpg', 128941, false, '7ac60382-db8e-4162-a203-c887f0e28bf1');
INSERT INTO ordenes_trabajo.archivo VALUES ('963c3a2b-91a2-43e7-b438-252b7e30772c', 'archivo_adjunto_2', 'archivo muestra de trabajo', '/uploads/5a0c0ecf-92fe-47c5-a282-37d502a641c3/', '2020-09-12 00:29:30', 'jpg', 128941, false, '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.archivo VALUES ('0c945ae2-f7c9-4afd-977f-119f82af1188', 'archivo_adjunto_1', 'a reparar', '/uploads/b35b8b26-0e07-4e9b-a948-d9131eb60a0d/', '2020-09-07 15:59:33', 'jpg', 156571, false, 'b35b8b26-0e07-4e9b-a948-d9131eb60a0d');
INSERT INTO ordenes_trabajo.archivo VALUES ('336a2681-1be3-49f1-8c65-ab4f78740975', 'archivo_adjunto_3', 'kkk', '/uploads/fb1b9715-7bcf-4ef7-bd75-a0949d94b750/', '2020-09-12 14:16:06', 'jpg', 128941, false, 'fb1b9715-7bcf-4ef7-bd75-a0949d94b750');
INSERT INTO ordenes_trabajo.archivo VALUES ('5dd0e166-1f6c-4329-a951-fac88cc3d2b5', 'archivo_adjunto_2', 'foto ejemplo de mueble', '/uploads/232173f5-5ca5-49eb-b060-beaba62e007b/', '2020-09-13 10:27:32', 'jpg', 128941, false, '232173f5-5ca5-49eb-b060-beaba62e007b');


--
-- TOC entry 3100 (class 0 OID 31141)
-- Dependencies: 200
-- Data for Name: estado; Type: TABLE DATA; Schema: ordenes_trabajo; Owner: demo
--

INSERT INTO ordenes_trabajo.estado VALUES ('578fa5e2-8044-4b62-b4e9-e41821c658cc', 'BORRADOR');
INSERT INTO ordenes_trabajo.estado VALUES ('9007850e-8a7b-47c5-8747-4ead8ff3e134', 'PENDIENTE');
INSERT INTO ordenes_trabajo.estado VALUES ('45077e45-8a78-4b4d-9abb-c7e6c9fb3d07', 'EN PROGRESO');
INSERT INTO ordenes_trabajo.estado VALUES ('27ab5c71-a7b4-411b-bba4-4d4a98efcfc0', 'FINALIZADO');
INSERT INTO ordenes_trabajo.estado VALUES ('cac4692d-9d34-4509-beb8-f0799c5fb256', 'FINALIZADO PARCIAL');
INSERT INTO ordenes_trabajo.estado VALUES ('a7e665d8-e653-4a6f-89a4-e40916f5a3ef', 'ANULADA');


--
-- TOC entry 3105 (class 0 OID 31175)
-- Dependencies: 205
-- Data for Name: historial_estado_archivo; Type: TABLE DATA; Schema: ordenes_trabajo; Owner: demo
--



--
-- TOC entry 3099 (class 0 OID 31133)
-- Dependencies: 199
-- Data for Name: historial_estado_orden_trabajo; Type: TABLE DATA; Schema: ordenes_trabajo; Owner: demo
--

INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('fabd386e-355c-456e-94e3-574701363b67', '9007850e-8a7b-47c5-8747-4ead8ff3e134', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-13 10:28:18', 'para completar. Se vuelve tarea a estado pendiente por falta de materiales', '232173f5-5ca5-49eb-b060-beaba62e007b');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('9b90cdec-5d58-48de-9966-c8d1d98b723b', '9007850e-8a7b-47c5-8747-4ead8ff3e134', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-11 09:55:05', 'para hacer despues del medio  dia', 'fb1b9715-7bcf-4ef7-bd75-a0949d94b750');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('05bf08c9-84d0-44fc-a2de-46528c47c941', '578fa5e2-8044-4b62-b4e9-e41821c658cc', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-13 18:27:39', NULL, '7f73c04c-8750-418e-9b32-de6b48554326');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('99f76da8-580d-465b-a129-ebdbef4c382d', '9007850e-8a7b-47c5-8747-4ead8ff3e134', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-13 18:30:39', NULL, '7f73c04c-8750-418e-9b32-de6b48554326');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('e9c8dbe4-6579-4eb4-9a1e-3ce4bb0d757b', '45077e45-8a78-4b4d-9abb-c7e6c9fb3d07', 'b060b892-fa7e-4285-8df5-0ea070450ce6', '2020-09-13 22:03:18', '', '275c32f0-b7f5-4052-b30a-dc367cb3b3fe');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('96ea4df1-31fb-4243-a6c3-7ec786318a46', 'a7e665d8-e653-4a6f-89a4-e40916f5a3ef', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-14 00:04:13', NULL, '7f73c04c-8750-418e-9b32-de6b48554326');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('e3de5287-5f98-4f18-8498-71f34b617bc6', '578fa5e2-8044-4b62-b4e9-e41821c658cc', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-14 08:12:01', NULL, 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('bd0d8132-bd6b-4f3a-a9f1-b11b9116eb38', '9007850e-8a7b-47c5-8747-4ead8ff3e134', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-05 10:03:10', 'Realizar tarea', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('35e425dc-088d-447f-9fa2-fd103358138c', '9007850e-8a7b-47c5-8747-4ead8ff3e134', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-14 08:28:23', 'Para hacer mañana. ', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('a589b9ca-7786-4456-a879-bee614e552ac', '578fa5e2-8044-4b62-b4e9-e41821c658cc', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-05 09:53:40', NULL, '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('021ed648-1dee-4ee2-9c99-f5e995eaa82f', '45077e45-8a78-4b4d-9abb-c7e6c9fb3d07', 'b060b892-fa7e-4285-8df5-0ea070450ce6', '2020-09-14 08:53:42', 'COMIENZO A REALIZAR LA TEREA', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('def855dd-b7ea-45e7-9de5-32179f207411', '578fa5e2-8044-4b62-b4e9-e41821c658cc', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-14 09:26:10', NULL, '66ae6209-8085-4dd9-bf1c-47aa2666cbc8');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('b32487ee-634b-4c01-901c-191d1851e2cc', '578fa5e2-8044-4b62-b4e9-e41821c658cc', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-14 11:02:35', NULL, '7167302a-c59a-4c41-83c0-65906b1536f3');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('739679b8-a42c-4834-a34e-aafabeb7dd6a', '9007850e-8a7b-47c5-8747-4ead8ff3e134', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-14 11:07:11', 'comentario
', '7167302a-c59a-4c41-83c0-65906b1536f3');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('f55828eb-2d8a-4836-80f2-2bbcd01c6412', '45077e45-8a78-4b4d-9abb-c7e6c9fb3d07', '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2', '2020-09-14 11:13:10', 'paso a progreso', '7167302a-c59a-4c41-83c0-65906b1536f3');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('ce8ea63e-9518-42d4-a053-3375cfb1d478', 'cac4692d-9d34-4509-beb8-f0799c5fb256', '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2', '2020-09-14 11:13:57', 'finalizo', '7167302a-c59a-4c41-83c0-65906b1536f3');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('1cb93724-5378-4225-b652-62e91a320357', '578fa5e2-8044-4b62-b4e9-e41821c658cc', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-07 15:58:22', NULL, 'b35b8b26-0e07-4e9b-a948-d9131eb60a0d');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('e9d607c0-4d97-43bf-9776-14f922013409', '578fa5e2-8044-4b62-b4e9-e41821c658cc', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-08 00:20:05', NULL, '275c32f0-b7f5-4052-b30a-dc367cb3b3fe');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('a832b72f-8bc5-43cb-afa6-5b9c5921a75c', '9007850e-8a7b-47c5-8747-4ead8ff3e134', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-09 01:16:18', NULL, '275c32f0-b7f5-4052-b30a-dc367cb3b3fe');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('1ba61e42-8f7e-4acf-a7bd-676056cb220b', '578fa5e2-8044-4b62-b4e9-e41821c658cc', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-12 00:31:17', NULL, '52f57404-9fc9-477f-ba84-e166071898a6');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('5fbdc114-e013-45da-b382-ebb64fc4b8d2', '578fa5e2-8044-4b62-b4e9-e41821c658cc', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-11 09:52:41', NULL, 'fb1b9715-7bcf-4ef7-bd75-a0949d94b750');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('8d739a55-5ff2-4af2-b4f1-17cb73f3d0d8', '9007850e-8a7b-47c5-8747-4ead8ff3e134', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-12 00:33:40', 'Hablar con Carlos antes de comenzar', '52f57404-9fc9-477f-ba84-e166071898a6');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('80109200-5b96-42a0-a7f6-e2ba0b485c6b', '45077e45-8a78-4b4d-9abb-c7e6c9fb3d07', '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2', '2020-09-12 13:43:23', '', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('f72add09-86bf-48fc-a995-b2d79dd29c62', '45077e45-8a78-4b4d-9abb-c7e6c9fb3d07', 'b060b892-fa7e-4285-8df5-0ea070450ce6', '2020-09-12 10:06:42', 'comienzo tarea atrasada. No hay personal en la oficina. Espera de Material.', '52f57404-9fc9-477f-ba84-e166071898a6');
INSERT INTO ordenes_trabajo.historial_estado_orden_trabajo VALUES ('7401bc72-8b17-4084-a7e2-cf302f28c188', '578fa5e2-8044-4b62-b4e9-e41821c658cc', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-13 10:03:51', NULL, '232173f5-5ca5-49eb-b060-beaba62e007b');


--
-- TOC entry 3102 (class 0 OID 31156)
-- Dependencies: 202
-- Data for Name: inmueble; Type: TABLE DATA; Schema: ordenes_trabajo; Owner: demo
--

INSERT INTO ordenes_trabajo.inmueble VALUES ('f1d03167-2a3d-49a5-80e2-6e00b7519fe3', 'ESTUDIO BELGRANO 220', '5907c5a3-26cb-4ada-8fbc-f1d0e293a073');
INSERT INTO ordenes_trabajo.inmueble VALUES ('eb93eeab-105e-4129-a410-77a32800379c', 'CENTRAL', '5907c5a3-26cb-4ada-8fbc-f1d0e293a073');
INSERT INTO ordenes_trabajo.inmueble VALUES ('dcaebfaa-0f15-4d7c-8f3b-d13e6d2fc605', 'ADMINSTRACION', '5907c5a3-26cb-4ada-8fbc-f1d0e293a073');


--
-- TOC entry 3116 (class 0 OID 31481)
-- Dependencies: 216
-- Data for Name: modificaciones_ot; Type: TABLE DATA; Schema: ordenes_trabajo; Owner: demo
--

INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('ea99d1f7-4e3c-4cea-bd8d-b799139d4309', 'Asignación de tarea al usuario mfernandez', '2020-09-10 00:22:30', '275c32f0-b7f5-4052-b30a-dc367cb3b3fe');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('c807403c-3094-4c99-9aa7-b848e9103c4a', 'Se vuelve la orden a estado: PENDIENTE, por el usuario mfernandez', '2020-09-11 22:05:04', 'fb1b9715-7bcf-4ef7-bd75-a0949d94b750');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('dfada3bc-f910-42f3-b320-4c33678cc231', 'Se pasa la orden a estado : EN PROGRESO, por el usuario mfernandez', '2020-09-11 22:20:54', 'fb1b9715-7bcf-4ef7-bd75-a0949d94b750');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('d93cff28-8bdd-472e-b456-ea950f08e30a', 'Se vuelve la orden a estado: PENDIENTE, por el usuario mfernandez', '2020-09-11 22:29:03', 'fb1b9715-7bcf-4ef7-bd75-a0949d94b750');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('f5917208-f860-4e9c-ae16-7da1e7403363', 'Se pasa la orden a estado : EN PROGRESO, por el usuario mfernandez', '2020-09-11 22:29:10', 'fb1b9715-7bcf-4ef7-bd75-a0949d94b750');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('108d9be9-51cb-4ae5-8aeb-5acf23872551', 'Orden creada, por cgarcia', '2020-09-11 22:47:29', '7ac60382-db8e-4162-a203-c887f0e28bf1');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('1c21235d-8385-4a83-aebc-3725b687c991', 'Orden creada, por cgarcia', '2020-09-12 00:31:17', '52f57404-9fc9-477f-ba84-e166071898a6');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('74f0b20d-c668-4090-a810-ec6c5e1040ba', 'Asignación de tarea al usuario pmartinez', '2020-09-12 10:06:02', '52f57404-9fc9-477f-ba84-e166071898a6');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('7d31598b-e6ef-414a-a5c0-81cbe9454934', 'Se pasa la orden a estado : EN PROGRESO, por el usuario pmartinez', '2020-09-12 10:06:42', '52f57404-9fc9-477f-ba84-e166071898a6');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('ab4a0b40-27e7-4a93-8285-6e423efad16d', 'Asignación de tarea al usuario pmartinez', '2020-09-12 10:19:21', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('29b6f835-cdf5-4768-9ab5-2a2de206d4cd', 'Asignación de tarea al usuario mfernandez', '2020-09-12 10:19:51', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('79d4690d-7932-4f59-9fd7-45583800f403', 'Se pasa la orden a estado : EN PROGRESO, por el usuario mfernandez', '2020-09-12 10:20:40', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('91f52aca-6406-4d0a-b613-afc4d83c0118', 'Se vuelve la orden a estado: PENDIENTE, por el usuario mfernandez', '2020-09-12 10:23:27', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('22691329-9397-4482-a252-63731551235b', 'Se pasa la orden a estado : EN PROGRESO, por el usuario mfernandez', '2020-09-12 10:36:46', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('57736668-5b76-453e-badd-b2505ffbf243', 'Se vuelve la orden a estado: PENDIENTE, por el usuario mfernandez', '2020-09-12 10:38:52', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('8d2fa0ef-78ab-4b16-a933-bef779700e9f', 'Se pasa la orden a estado : EN PROGRESO, por el usuario mfernandez', '2020-09-12 10:39:05', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('2fa1a03a-3721-484c-9684-c8701cfc7dab', 'Se pasa la orden a estado : FINALIZADO, por el usuario mfernandez', '2020-09-12 10:40:37', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('41199c12-9d1d-4065-9715-57a8d7f110ab', 'Se vuelve la orden a estado: EN PROGRESO, por el usuario mfernandez', '2020-09-12 10:43:05', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('79bcaf15-4616-48e7-adc4-62cddf4b0789', 'Se pasa la orden a estado : FINALIZADO PARCIAL, por el usuario mfernandez', '2020-09-12 10:43:18', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('73ef1b6f-59f5-4d00-a7e6-6e3340d4463a', 'Se vuelve la orden a estado: EN PROGRESO, por el usuario mfernandez', '2020-09-12 10:44:33', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('20b0b548-f245-44b9-92a8-2f644af5930d', 'Se pasa la orden a estado : FINALIZADO PARCIAL, por el usuario mfernandez', '2020-09-12 10:44:53', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('90898fed-eb40-46c3-a579-3969c820e275', 'Se vuelve la orden a estado: EN PROGRESO, por el usuario mfernandez', '2020-09-12 10:47:05', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('845e0c8a-46b8-4de2-91f3-8b572a4bb8ab', 'Se vuelve la orden a estado: PENDIENTE, por el usuario mfernandez', '2020-09-12 13:19:41', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('4fd7587c-dfb7-4f47-a3a5-dfed2e087184', 'Se pasa la orden a estado : EN PROGRESO, por el usuario mfernandez', '2020-09-12 13:19:51', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('bd0964d8-e13c-4077-9353-9fb8db2c35c3', 'Se vuelve la orden a estado: PENDIENTE, por el usuario mfernandez', '2020-09-12 13:25:32', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('b0fb3ca0-0686-4ca9-90ec-0733b529e2eb', 'Se pasa la orden a estado : EN PROGRESO, por el usuario mfernandez', '2020-09-12 13:25:42', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('1e3838ce-7dbb-41af-961d-aca7aeeb5219', 'Se vuelve la orden a estado: PENDIENTE, por el usuario mfernandez', '2020-09-12 13:26:24', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('a26cc2ad-e8ba-4f68-a30a-0575bf3fea91', 'Se pasa la orden a estado : EN PROGRESO, por el usuario mfernandez', '2020-09-12 13:26:35', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('2c1f38ce-d90c-4ef1-b27c-c240d5455778', 'Se vuelve la orden a estado: PENDIENTE, por el usuario mfernandez', '2020-09-12 13:30:02', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('a7ac1354-ceb5-4575-97a6-1b9f7e3fd7d0', 'Se pasa la orden a estado : EN PROGRESO, por el usuario mfernandez', '2020-09-12 13:31:37', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('fbe026e9-af90-4959-b55a-5c06712170eb', 'Se pasa la orden a estado : EN PROGRESO, por el usuario mfernandez', '2020-09-12 13:34:09', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('0fb41219-69b0-4cbe-b082-1c7c97d9a81c', 'Se pasa la orden a estado : FINALIZADO, por el usuario mfernandez', '2020-09-12 13:36:06', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('50e7f4ab-4db7-4767-ba9e-8512881b6ead', 'Se vuelve la orden a estado: EN PROGRESO, por el usuario mfernandez', '2020-09-12 13:39:57', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('b3e87aaf-491f-42f9-ae34-8a5c405fa1e2', 'Se vuelve la orden a estado: EN PROGRESO, por el usuario mfernandez', '2020-09-12 13:40:08', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('81514c28-062b-4ce8-b0d9-ccca79cd9275', 'Se vuelve la orden a estado: PENDIENTE, por el usuario mfernandez', '2020-09-12 13:40:22', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('32c4af5f-6ea4-4440-904d-abd29a47110e', 'Se pasa la orden a estado : EN PROGRESO, por el usuario mfernandez', '2020-09-12 13:40:30', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('fa528ec6-4e89-4134-8c5d-e00054039808', 'Se vuelve la orden a estado: PENDIENTE, por el usuario mfernandez', '2020-09-12 13:41:08', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('39a8e3a8-c75d-4ec8-9ae3-9948ef170ff6', 'Se pasa la orden a estado : EN PROGRESO, por el usuario mfernandez', '2020-09-12 13:41:14', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('37456277-ebb0-4887-aec3-c449c7220ba8', 'Se vuelve la orden a estado: PENDIENTE, por el usuario mfernandez', '2020-09-12 13:41:31', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('722ad48e-d2a6-48d2-84f3-0353106d45c9', 'Se pasa la orden a estado : EN PROGRESO, por el usuario mfernandez', '2020-09-12 13:41:36', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('d7968a81-8ccd-41e8-96ab-78eff5628591', 'Se vuelve la orden a estado: PENDIENTE, por el usuario mfernandez', '2020-09-12 13:43:17', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('f3e50581-33fc-452d-ac85-7e084d7cc759', 'Se pasa la orden a estado : EN PROGRESO, por el usuario mfernandez', '2020-09-12 13:43:23', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('83992463-83f9-43b8-a766-2efb763370fc', 'Se pasa la orden a estado : FINALIZADO, por el usuario mfernandez', '2020-09-12 13:48:41', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('a11321c3-1dc7-413e-a339-4c6c2f6b4692', 'Se pasa la orden a estado : FINALIZADO, por el usuario cgarcia', '2020-09-12 16:47:10', 'fb1b9715-7bcf-4ef7-bd75-a0949d94b750');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('e2262dad-09e8-4b89-bffa-dc63768d5b41', 'Orden creada, por cgarcia', '2020-09-12 17:12:59', '27833649-0b52-4509-a33c-339af5033400');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('da6654dc-d6f1-4fb8-bda2-7ff81f2b7cea', 'Se pasa la orden a estado : FINALIZADO, por el usuario cgarcia', '2020-09-12 23:21:58', '52f57404-9fc9-477f-ba84-e166071898a6');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('7e19743b-e90d-45c3-a243-76e848126057', 'Se vuelve la orden a estado: EN PROGRESO, por el usuario cgarcia', '2020-09-13 09:58:01', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('66619341-aeb8-408a-bb7c-85ead6bbbb29', 'Se vuelve la orden a estado: EN PROGRESO, por el usuario cgarcia', '2020-09-13 09:59:26', '275c32f0-b7f5-4052-b30a-dc367cb3b3fe');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('f9de3793-7caf-4b51-8811-2a5e356131cf', 'Se vuelve la orden a estado: PENDIENTE, por el usuario cgarcia', '2020-09-13 09:59:30', '275c32f0-b7f5-4052-b30a-dc367cb3b3fe');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('0582dcbc-fd9d-4774-931b-f0dc3f904c4c', 'Se vuelve la orden a estado: EN PROGRESO, por el usuario cgarcia', '2020-09-13 09:59:49', 'fb1b9715-7bcf-4ef7-bd75-a0949d94b750');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('9299027a-3ffb-4652-82b2-933f48f90313', 'Se vuelve la orden a estado: PENDIENTE, por el usuario cgarcia', '2020-09-13 09:59:57', 'fb1b9715-7bcf-4ef7-bd75-a0949d94b750');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('4b3d83a7-6ddb-4ccb-a307-de43d521cc4d', 'Orden creada, por cgarcia', '2020-09-13 10:03:51', '232173f5-5ca5-49eb-b060-beaba62e007b');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('09654f9d-00b8-48e8-8f77-311182b1d5c7', 'Se pasa la orden a estado : EN PROGRESO, por el usuario cgarcia', '2020-09-13 10:30:30', '232173f5-5ca5-49eb-b060-beaba62e007b');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('47006500-fd89-4d9b-bdaa-9fea7d61ab00', 'Se vuelve la orden a estado: PENDIENTE, por el usuario cgarcia', '2020-09-13 10:31:08', '232173f5-5ca5-49eb-b060-beaba62e007b');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('6eda9d95-da10-4385-9540-7c3dd8b1789a', 'Se pasa la orden a estado : EN PROGRESO, por el usuario cgarcia', '2020-09-13 15:01:05', 'fb1b9715-7bcf-4ef7-bd75-a0949d94b750');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('96943e0a-314c-419b-a079-d17c330d9626', 'Se vuelve la orden a estado: PENDIENTE, por el usuario cgarcia', '2020-09-13 15:03:00', 'fb1b9715-7bcf-4ef7-bd75-a0949d94b750');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('06f53bfa-fb42-4da8-98c4-64d827dd0b77', 'Orden creada, por mfernandez', '2020-09-13 17:53:28', 'c40bae75-9a22-43e0-b265-4a4a954c7877');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('e8cc2361-dde8-433e-a0a5-72febd318adb', 'Orden creada, por cgarcia', '2020-09-13 18:27:39', '7f73c04c-8750-418e-9b32-de6b48554326');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('4c39b0bf-9a99-4af0-abbe-e331b0672b5e', 'Asignación de tarea al usuario mfernandez', '2020-09-13 19:57:49', '52f57404-9fc9-477f-ba84-e166071898a6');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('3ef09c3d-f9f7-456f-a00b-32801143649d', 'Asignación de tarea al usuario pmartinez', '2020-09-13 22:02:39', '275c32f0-b7f5-4052-b30a-dc367cb3b3fe');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('f4c57610-f8be-428a-8f3f-ca58a61947bc', 'Se pasa la orden a estado : EN PROGRESO, por el usuario pmartinez', '2020-09-13 22:03:19', '275c32f0-b7f5-4052-b30a-dc367cb3b3fe');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('79cbaaee-08a4-47a4-8521-8a721b30e0fd', 'Orden creada, por mfernandez', '2020-09-13 22:04:35', '29c06783-3fdc-4d8a-af58-dee9e31cad0a');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('1fd5b014-e00d-4b8f-b330-46ddf5859721', 'Orden creada, por cgarcia', '2020-09-13 23:07:54', '6125d487-8597-48b5-956a-f2cc71b64aeb');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('21af201e-9e38-4a81-aebb-c741d79d1362', 'Se vuelve la orden a estado: EN PROGRESO, por el usuario cgarcia', '2020-09-13 23:09:47', '52f57404-9fc9-477f-ba84-e166071898a6');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('0f9234bd-59ce-42d4-b9bd-96817558b856', 'Se anula orden 000009-2020, por el usuario cgarcia', '2020-09-14 00:04:13', '7f73c04c-8750-418e-9b32-de6b48554326');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('9b2a8ad5-91df-4400-ad51-77a1545e9433', 'Orden creada, por cgarcia', '2020-09-14 00:12:16', '185d0289-adf3-42c3-a705-fb8cb7dd6b71');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('707dd9e2-3c58-448b-976c-f3ecdba6e13a', 'Orden creada, por cgarcia', '2020-09-14 08:12:01', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('fcc12434-bfb1-4b31-902b-d3d36a716a68', 'Asignación de tarea al usuario pmartinez', '2020-09-14 08:43:10', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('7981a9a3-fc57-4ba4-8923-2c78e8b755f0', 'Se pasa la orden a estado : EN PROGRESO, por el usuario pmartinez', '2020-09-14 08:45:53', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('94fd7ce0-010c-4889-a379-b8d2339ff019', 'Se vuelve la orden a estado: PENDIENTE, por el usuario pmartinez', '2020-09-14 08:47:03', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('a96f50e7-7cf1-4583-a540-b5a036343930', 'Se pasa la orden a estado : EN PROGRESO, por el usuario pmartinez', '2020-09-14 08:53:42', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('6e9a4bac-4195-4d84-8fee-5399e1253bdc', 'Se pasa la orden a estado : FINALIZADO PARCIAL, por el usuario pmartinez', '2020-09-14 08:54:51', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('bb66e386-ee30-4c92-b8b4-08ce720abffb', 'Se vuelve la orden a estado: EN PROGRESO, por el usuario pmartinez', '2020-09-14 08:56:28', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('b151f175-649e-4180-8402-dcb932bce42a', 'Asignación de tarea al usuario mfernandez', '2020-09-14 08:57:30', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('8291e78a-f839-457c-ae34-c852a1714f77', 'Se pasa la orden a estado : FINALIZADO, por el usuario mfernandez', '2020-09-14 08:57:48', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('0dfe9aa4-d754-4feb-a701-b35998bba129', 'Se vuelve la orden a estado: EN PROGRESO, por el usuario mfernandez', '2020-09-14 09:02:58', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('33f6c92d-8b06-470d-aea1-07183cab5a8b', 'Se pasa la orden a estado : FINALIZADO, por el usuario mfernandez', '2020-09-14 09:03:08', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('f601ac8e-2298-431e-b16e-cad65aafe8cb', 'Se vuelve la orden a estado: EN PROGRESO, por el usuario mfernandez', '2020-09-14 09:05:32', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('e6f24f14-a86c-45d3-aafb-15177d1e9740', 'Se pasa la orden a estado : FINALIZADO, por el usuario mfernandez', '2020-09-14 09:06:06', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('3756a7e0-550a-4fca-8652-bd22dbe08cd0', 'Se vuelve la orden a estado: EN PROGRESO, por el usuario mfernandez', '2020-09-14 09:08:28', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('b376c182-0fe7-43d8-96cc-de0dd17fa29d', 'Se pasa la orden a estado : FINALIZADO, por el usuario mfernandez', '2020-09-14 09:09:16', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('55240e09-908b-46c4-9e5c-593511fff162', 'Se vuelve la orden a estado: EN PROGRESO, por el usuario mfernandez', '2020-09-14 09:09:40', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('fc5d7d7f-0423-4685-81ec-54c43c63669f', 'Se pasa la orden a estado : FINALIZADO, por el usuario mfernandez', '2020-09-14 09:10:24', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('9cf4c321-d8e8-4d41-a573-7077ec7dfe55', 'Se vuelve la orden a estado: EN PROGRESO, por el usuario mfernandez', '2020-09-14 09:12:32', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('26876acf-2d79-4c8a-972f-d3d53b40589b', 'Orden creada, por cgarcia', '2020-09-14 09:26:10', '66ae6209-8085-4dd9-bf1c-47aa2666cbc8');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('6b144aa1-30c5-48a9-a428-522e5681f079', 'Orden creada, por cgarcia', '2020-09-14 11:02:35', '7167302a-c59a-4c41-83c0-65906b1536f3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('2ea5bd91-dd95-4916-a231-bc9a09cc1578', 'Asignación de tarea al usuario mfernandez', '2020-09-14 11:11:22', '7167302a-c59a-4c41-83c0-65906b1536f3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('a9480b4b-9975-4775-a92d-73577a9332b5', 'Se pasa la orden a estado : EN PROGRESO, por el usuario mfernandez', '2020-09-14 11:13:10', '7167302a-c59a-4c41-83c0-65906b1536f3');
INSERT INTO ordenes_trabajo.modificaciones_ot VALUES ('5b3a2ff3-212b-4c7d-895f-5fee040fd8d8', 'Se pasa la orden a estado : FINALIZADO PARCIAL, por el usuario mfernandez', '2020-09-14 11:13:57', '7167302a-c59a-4c41-83c0-65906b1536f3');


--
-- TOC entry 3115 (class 0 OID 31470)
-- Dependencies: 215
-- Data for Name: orden_anio_nro; Type: TABLE DATA; Schema: ordenes_trabajo; Owner: demo
--

INSERT INTO ordenes_trabajo.orden_anio_nro VALUES ('ac3d9eab-7233-4fd3-b4f2-3eaad524fc49', 2020, 11);


--
-- TOC entry 3098 (class 0 OID 31126)
-- Dependencies: 198
-- Data for Name: ordenes_trabajo; Type: TABLE DATA; Schema: ordenes_trabajo; Owner: demo
--

INSERT INTO ordenes_trabajo.ordenes_trabajo VALUES ('b35b8b26-0e07-4e9b-a948-d9131eb60a0d', '000004-2020', '2020-09-07 15:58:22', NULL, 'Cambiar pisos', '1cb93724-5378-4225-b652-62e91a320357', '7ce17fdb-1797-4916-be9f-7454b557c233', 'f1d03167-2a3d-49a5-80e2-6e00b7519fe3', 'Cambio piso oficina Belgrano 220', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-09 20:00:00', NULL);
INSERT INTO ordenes_trabajo.ordenes_trabajo VALUES ('a2256f6d-3b73-4522-8fbe-6617e2b90a33', '000010-2020', '2020-09-14 08:12:01', '2020-09-14 09:10:24', 'Mantenimiento de AACC, verificación gas, limpieza de filtros.', '021ed648-1dee-4ee2-9c99-f5e995eaa82f', '8a226a53-61d0-4932-b1ff-d0054d9d1dda', 'eb93eeab-105e-4129-a410-77a32800379c', 'Mantenimiento de AACC', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-14 13:00:00', '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2');
INSERT INTO ordenes_trabajo.ordenes_trabajo VALUES ('52f57404-9fc9-477f-ba84-e166071898a6', '000007-2020', '2020-09-12 00:31:17', NULL, 'Orden Nueva para mantenimiento de aires acondicionados', 'f72add09-86bf-48fc-a995-b2d79dd29c62', 'a8f1aacc-aff7-48d0-bbd6-a3096dc3fe66', 'f1d03167-2a3d-49a5-80e2-6e00b7519fe3', 'Nueva Orden ', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-15 13:00:00', '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2');
INSERT INTO ordenes_trabajo.ordenes_trabajo VALUES ('7f73c04c-8750-418e-9b32-de6b48554326', '000009-2020', '2020-09-13 18:27:38', NULL, 'Pintar puerta de sala principal', '96ea4df1-31fb-4243-a6c3-7ec786318a46', '8a226a53-61d0-4932-b1ff-d0054d9d1dda', 'f1d03167-2a3d-49a5-80e2-6e00b7519fe3', 'Pintar puertas', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-13 13:00:00', NULL);
INSERT INTO ordenes_trabajo.ordenes_trabajo VALUES ('5a0c0ecf-92fe-47c5-a282-37d502a641c3', '000003-2020', '2020-09-05 09:53:40', NULL, 'Mi primera orden de trabajo para reparar agua de la oficina', '80109200-5b96-42a0-a7f6-e2ba0b485c6b', 'a8f1aacc-aff7-48d0-bbd6-a3096dc3fe66', 'f1d03167-2a3d-49a5-80e2-6e00b7519fe3', 'Es mi primera orden de trabajo', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-07 13:00:00', '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2');
INSERT INTO ordenes_trabajo.ordenes_trabajo VALUES ('66ae6209-8085-4dd9-bf1c-47aa2666cbc8', NULL, '2020-09-14 09:26:10', NULL, NULL, 'def855dd-b7ea-45e7-9de5-32179f207411', NULL, NULL, NULL, '5eee1664-f350-4ec9-8619-9d7c391aaf87', NULL, NULL);
INSERT INTO ordenes_trabajo.ordenes_trabajo VALUES ('29c06783-3fdc-4d8a-af58-dee9e31cad0a', NULL, '2020-09-13 22:04:35', NULL, NULL, NULL, NULL, NULL, NULL, '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2', NULL, NULL);
INSERT INTO ordenes_trabajo.ordenes_trabajo VALUES ('27833649-0b52-4509-a33c-339af5033400', NULL, '2020-09-12 17:12:59', NULL, NULL, NULL, NULL, NULL, NULL, '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-09 20:00:00', NULL);
INSERT INTO ordenes_trabajo.ordenes_trabajo VALUES ('185d0289-adf3-42c3-a705-fb8cb7dd6b71', NULL, '2020-09-14 00:12:16', NULL, NULL, NULL, NULL, NULL, NULL, '5eee1664-f350-4ec9-8619-9d7c391aaf87', NULL, NULL);
INSERT INTO ordenes_trabajo.ordenes_trabajo VALUES ('7ac60382-db8e-4162-a203-c887f0e28bf1', NULL, '2020-09-11 22:47:29', NULL, NULL, NULL, NULL, NULL, NULL, '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-09 20:00:00', NULL);
INSERT INTO ordenes_trabajo.ordenes_trabajo VALUES ('f78c0717-3b97-42ac-b702-3a58cc926394', NULL, '2020-09-09 21:18:29', NULL, NULL, NULL, NULL, NULL, NULL, '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-09 20:00:00', NULL);
INSERT INTO ordenes_trabajo.ordenes_trabajo VALUES ('c40bae75-9a22-43e0-b265-4a4a954c7877', NULL, '2020-09-13 17:53:27', NULL, NULL, NULL, NULL, NULL, NULL, '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2', NULL, NULL);
INSERT INTO ordenes_trabajo.ordenes_trabajo VALUES ('6125d487-8597-48b5-956a-f2cc71b64aeb', NULL, '2020-09-13 23:07:53', NULL, NULL, NULL, NULL, NULL, NULL, '5eee1664-f350-4ec9-8619-9d7c391aaf87', NULL, NULL);
INSERT INTO ordenes_trabajo.ordenes_trabajo VALUES ('232173f5-5ca5-49eb-b060-beaba62e007b', '000008-2020', '2020-09-13 10:03:51', NULL, 'Armar muebles en la oficina de administración.', 'fabd386e-355c-456e-94e3-574701363b67', '7ce17fdb-1797-4916-be9f-7454b557c233', 'f1d03167-2a3d-49a5-80e2-6e00b7519fe3', 'Armar muebles', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-13 13:30:00', NULL);
INSERT INTO ordenes_trabajo.ordenes_trabajo VALUES ('7167302a-c59a-4c41-83c0-65906b1536f3', '000011-2020', '2020-09-14 11:02:35', '2020-09-14 11:13:57', 'Pintar puertas frente.', 'ce8ea63e-9518-42d4-a053-3375cfb1d478', '8a226a53-61d0-4932-b1ff-d0054d9d1dda', 'eb93eeab-105e-4129-a410-77a32800379c', 'Pintar puertas', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-14 13:00:00', '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2');
INSERT INTO ordenes_trabajo.ordenes_trabajo VALUES ('fb1b9715-7bcf-4ef7-bd75-a0949d94b750', '000006-2020', '2020-09-11 09:52:41', NULL, 'fff', '9b90cdec-5d58-48de-9966-c8d1d98b723b', 'a8f1aacc-aff7-48d0-bbd6-a3096dc3fe66', 'f1d03167-2a3d-49a5-80e2-6e00b7519fe3', 'fff', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-24 10:00:00', '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2');
INSERT INTO ordenes_trabajo.ordenes_trabajo VALUES ('275c32f0-b7f5-4052-b30a-dc367cb3b3fe', '000005-2020', '2020-09-08 00:20:05', NULL, 'Limpiar desague techos, existen quejas', 'e9c8dbe4-6579-4eb4-9a1e-3ce4bb0d757b', 'a8f1aacc-aff7-48d0-bbd6-a3096dc3fe66', 'f1d03167-2a3d-49a5-80e2-6e00b7519fe3', 'Limpiar desague techo', '5eee1664-f350-4ec9-8619-9d7c391aaf87', '2020-09-13 10:00:00', 'b060b892-fa7e-4285-8df5-0ea070450ce6');


--
-- TOC entry 3108 (class 0 OID 31322)
-- Dependencies: 208
-- Data for Name: persona; Type: TABLE DATA; Schema: ordenes_trabajo; Owner: demo
--

INSERT INTO ordenes_trabajo.persona VALUES ('85fa9cd6-0a72-43be-bd4e-b1c7a866b920', 'Garcia', 'Carlos', '5907c5a3-26cb-4ada-8fbc-f1d0e293a073');
INSERT INTO ordenes_trabajo.persona VALUES ('7e356690-04c6-4a02-9260-01588cee490b', 'Martinez', 'Pablo', '5907c5a3-26cb-4ada-8fbc-f1d0e293a073');
INSERT INTO ordenes_trabajo.persona VALUES ('2f500cdd-89bd-41bd-8cfd-56b12a453a9d', 'Fernandez', 'Maria', '5907c5a3-26cb-4ada-8fbc-f1d0e293a073');


--
-- TOC entry 3109 (class 0 OID 31335)
-- Dependencies: 209
-- Data for Name: sucursal; Type: TABLE DATA; Schema: ordenes_trabajo; Owner: demo
--

INSERT INTO ordenes_trabajo.sucursal VALUES ('5907c5a3-26cb-4ada-8fbc-f1d0e293a073', 'MANTENIMIENTO VIEDMA');
INSERT INTO ordenes_trabajo.sucursal VALUES ('bbe6c762-6618-4824-8c83-d65b12dd8c78', 'MANTENIMIENTO BARILOCHE');


--
-- TOC entry 3106 (class 0 OID 31245)
-- Dependencies: 206
-- Data for Name: tipo_relacion; Type: TABLE DATA; Schema: ordenes_trabajo; Owner: demo
--



--
-- TOC entry 3101 (class 0 OID 31151)
-- Dependencies: 201
-- Data for Name: tipo_trabajo; Type: TABLE DATA; Schema: ordenes_trabajo; Owner: demo
--

INSERT INTO ordenes_trabajo.tipo_trabajo VALUES ('7ce17fdb-1797-4916-be9f-7454b557c233', 'PREVENTIVO');
INSERT INTO ordenes_trabajo.tipo_trabajo VALUES ('a8f1aacc-aff7-48d0-bbd6-a3096dc3fe66', 'OBRA MENOR');
INSERT INTO ordenes_trabajo.tipo_trabajo VALUES ('8a226a53-61d0-4932-b1ff-d0054d9d1dda', 'MANTENIMIENTO');


--
-- TOC entry 3107 (class 0 OID 31314)
-- Dependencies: 207
-- Data for Name: usuario; Type: TABLE DATA; Schema: ordenes_trabajo; Owner: demo
--

INSERT INTO ordenes_trabajo.usuario VALUES ('5eee1664-f350-4ec9-8619-9d7c391aaf87', '85fa9cd6-0a72-43be-bd4e-b1c7a866b920', NULL, 'cgarcia', 'cgarcia123', NULL, true);
INSERT INTO ordenes_trabajo.usuario VALUES ('b060b892-fa7e-4285-8df5-0ea070450ce6', '7e356690-04c6-4a02-9260-01588cee490b', 'usuario operador', 'pmartinez', 'pmartinez123', NULL, NULL);
INSERT INTO ordenes_trabajo.usuario VALUES ('55c69f1a-c736-42d7-b65b-0ddcc08f8bd2', '2f500cdd-89bd-41bd-8cfd-56b12a453a9d', 'usuario operador', 'mfernandez', 'mfernandez123', NULL, NULL);


--
-- TOC entry 3104 (class 0 OID 31170)
-- Dependencies: 204
-- Data for Name: usuario_orden_trabajo; Type: TABLE DATA; Schema: ordenes_trabajo; Owner: demo
--

INSERT INTO ordenes_trabajo.usuario_orden_trabajo VALUES ('5a1877ba-6ab5-4887-8cd2-c98744cfffe3', '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2', 'b35b8b26-0e07-4e9b-a948-d9131eb60a0d');
INSERT INTO ordenes_trabajo.usuario_orden_trabajo VALUES ('7dfb3533-6f0c-427e-aa27-54b5938b1a5c', 'b060b892-fa7e-4285-8df5-0ea070450ce6', 'b35b8b26-0e07-4e9b-a948-d9131eb60a0d');
INSERT INTO ordenes_trabajo.usuario_orden_trabajo VALUES ('fd466dbc-f5e8-4747-b0e5-79440520d1be', '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2', '275c32f0-b7f5-4052-b30a-dc367cb3b3fe');
INSERT INTO ordenes_trabajo.usuario_orden_trabajo VALUES ('37a23e5b-d589-426d-9330-2d69a0a361bc', 'b060b892-fa7e-4285-8df5-0ea070450ce6', '275c32f0-b7f5-4052-b30a-dc367cb3b3fe');
INSERT INTO ordenes_trabajo.usuario_orden_trabajo VALUES ('9dfd4803-51ea-4015-8bfe-67d6dcb695d2', '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.usuario_orden_trabajo VALUES ('f7390096-94d0-4520-9961-7678a31c3232', 'b060b892-fa7e-4285-8df5-0ea070450ce6', 'a2256f6d-3b73-4522-8fbe-6617e2b90a33');
INSERT INTO ordenes_trabajo.usuario_orden_trabajo VALUES ('e8d8940c-c832-47f3-a591-6d5a418109de', 'b060b892-fa7e-4285-8df5-0ea070450ce6', '7167302a-c59a-4c41-83c0-65906b1536f3');
INSERT INTO ordenes_trabajo.usuario_orden_trabajo VALUES ('7ef3f327-92c9-4534-85cb-9db809849e35', '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2', '7167302a-c59a-4c41-83c0-65906b1536f3');
INSERT INTO ordenes_trabajo.usuario_orden_trabajo VALUES ('360d96bc-4b09-4400-8a73-d6f6e229c010', '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.usuario_orden_trabajo VALUES ('d40edcc3-2e94-466c-9ab2-6aa12b306d44', 'b060b892-fa7e-4285-8df5-0ea070450ce6', '5a0c0ecf-92fe-47c5-a282-37d502a641c3');
INSERT INTO ordenes_trabajo.usuario_orden_trabajo VALUES ('fd6cc211-9505-400f-8543-cd5e02fb81ab', '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2', 'fb1b9715-7bcf-4ef7-bd75-a0949d94b750');
INSERT INTO ordenes_trabajo.usuario_orden_trabajo VALUES ('e764e366-04a5-4720-82ce-6bc2f959a048', 'b060b892-fa7e-4285-8df5-0ea070450ce6', '52f57404-9fc9-477f-ba84-e166071898a6');
INSERT INTO ordenes_trabajo.usuario_orden_trabajo VALUES ('69d1e0dc-17b1-46cb-8e73-2e4c366bca31', '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2', '52f57404-9fc9-477f-ba84-e166071898a6');
INSERT INTO ordenes_trabajo.usuario_orden_trabajo VALUES ('d6a70b88-4b37-4b0d-8ac2-20f596cdadfd', 'b060b892-fa7e-4285-8df5-0ea070450ce6', '232173f5-5ca5-49eb-b060-beaba62e007b');
INSERT INTO ordenes_trabajo.usuario_orden_trabajo VALUES ('8bc2ffe2-c2d2-4f9e-a50e-0ebe0cbbd5ec', '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2', '232173f5-5ca5-49eb-b060-beaba62e007b');


--
-- TOC entry 3114 (class 0 OID 31452)
-- Dependencies: 214
-- Data for Name: auth_assignment; Type: TABLE DATA; Schema: public; Owner: demo
--

INSERT INTO public.auth_assignment VALUES ('R_SUPERVISOR', '5eee1664-f350-4ec9-8619-9d7c391aaf87', NULL);
INSERT INTO public.auth_assignment VALUES ('R_OPERADOR', 'b060b892-fa7e-4285-8df5-0ea070450ce6', NULL);
INSERT INTO public.auth_assignment VALUES ('R_OPERADOR', '55c69f1a-c736-42d7-b65b-0ddcc08f8bd2', NULL);


--
-- TOC entry 3112 (class 0 OID 31423)
-- Dependencies: 212
-- Data for Name: auth_item; Type: TABLE DATA; Schema: public; Owner: demo
--

INSERT INTO public.auth_item VALUES ('R_SUPERVISOR', 1, NULL, NULL, NULL, 1599181222, 1599181222);
INSERT INTO public.auth_item VALUES ('R_OPERADOR', 1, NULL, NULL, NULL, 1599181262, 1599181262);
INSERT INTO public.auth_item VALUES ('P_OPERADOR', 2, NULL, NULL, NULL, 1599181310, 1599181310);
INSERT INTO public.auth_item VALUES ('P_SUPERVISOR', 2, NULL, NULL, NULL, 1599181360, 1599181360);
INSERT INTO public.auth_item VALUES ('P_EDITAR_ORDEN', 2, NULL, NULL, NULL, NULL, NULL);


--
-- TOC entry 3113 (class 0 OID 31437)
-- Dependencies: 213
-- Data for Name: auth_item_child; Type: TABLE DATA; Schema: public; Owner: demo
--

INSERT INTO public.auth_item_child VALUES ('R_OPERADOR', 'P_OPERADOR');
INSERT INTO public.auth_item_child VALUES ('R_SUPERVISOR', 'P_SUPERVISOR');
INSERT INTO public.auth_item_child VALUES ('R_SUPERVISOR', 'P_EDITAR_ORDEN');


--
-- TOC entry 3111 (class 0 OID 31415)
-- Dependencies: 211
-- Data for Name: auth_rule; Type: TABLE DATA; Schema: public; Owner: demo
--



--
-- TOC entry 3110 (class 0 OID 31410)
-- Dependencies: 210
-- Data for Name: migration; Type: TABLE DATA; Schema: public; Owner: demo
--

INSERT INTO public.migration VALUES ('m000000_000000_base', 1599179300);
INSERT INTO public.migration VALUES ('m140506_102106_rbac_init', 1599179399);
INSERT INTO public.migration VALUES ('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1599179399);
INSERT INTO public.migration VALUES ('m180523_151638_rbac_updates_indexes_without_prefix', 1599179399);
INSERT INTO public.migration VALUES ('m200409_110543_rbac_update_mssql_trigger', 1599179399);


--
-- TOC entry 2928 (class 2606 OID 31169)
-- Name: archivo archivo_pkey; Type: CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.archivo
    ADD CONSTRAINT archivo_pkey PRIMARY KEY (id_archivo);


--
-- TOC entry 2922 (class 2606 OID 31145)
-- Name: estado estado_pk; Type: CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.estado
    ADD CONSTRAINT estado_pk PRIMARY KEY (id_estado);


--
-- TOC entry 2932 (class 2606 OID 31179)
-- Name: historial_estado_archivo historial_estado_archivo_pk; Type: CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.historial_estado_archivo
    ADD CONSTRAINT historial_estado_archivo_pk PRIMARY KEY (id_historial_estado_archivo);


--
-- TOC entry 2920 (class 2606 OID 31140)
-- Name: historial_estado_orden_trabajo historial_orden_trabajo_pk; Type: CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.historial_estado_orden_trabajo
    ADD CONSTRAINT historial_orden_trabajo_pk PRIMARY KEY (id_historial_estado_orden_trabajo);


--
-- TOC entry 2926 (class 2606 OID 31160)
-- Name: inmueble inmueble_pk; Type: CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.inmueble
    ADD CONSTRAINT inmueble_pk PRIMARY KEY (id_inmueble);


--
-- TOC entry 2956 (class 2606 OID 31488)
-- Name: modificaciones_ot modificaciones_ot_pk; Type: CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.modificaciones_ot
    ADD CONSTRAINT modificaciones_ot_pk PRIMARY KEY (id_modificacion);


--
-- TOC entry 2954 (class 2606 OID 31475)
-- Name: orden_anio_nro orden_anio_nro_pk; Type: CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.orden_anio_nro
    ADD CONSTRAINT orden_anio_nro_pk PRIMARY KEY (id_orden_anio_nro);


--
-- TOC entry 2918 (class 2606 OID 31198)
-- Name: ordenes_trabajo ordenes_trabajo_pk; Type: CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.ordenes_trabajo
    ADD CONSTRAINT ordenes_trabajo_pk PRIMARY KEY (id_ordenes_trabajo);


--
-- TOC entry 2940 (class 2606 OID 31339)
-- Name: sucursal organismo_pk; Type: CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.sucursal
    ADD CONSTRAINT organismo_pk PRIMARY KEY (id_sucursal);


--
-- TOC entry 2938 (class 2606 OID 31329)
-- Name: persona persona_pk; Type: CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.persona
    ADD CONSTRAINT persona_pk PRIMARY KEY (id_persona);


--
-- TOC entry 2934 (class 2606 OID 31250)
-- Name: tipo_relacion tipo_relacion_pk; Type: CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.tipo_relacion
    ADD CONSTRAINT tipo_relacion_pk PRIMARY KEY (id_tipo_relacion);


--
-- TOC entry 2924 (class 2606 OID 31155)
-- Name: tipo_trabajo tipo_trabajo_pk; Type: CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.tipo_trabajo
    ADD CONSTRAINT tipo_trabajo_pk PRIMARY KEY (id_tipo_trabajo);


--
-- TOC entry 2930 (class 2606 OID 31174)
-- Name: usuario_orden_trabajo usuario_orden_trabajo_pk; Type: CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.usuario_orden_trabajo
    ADD CONSTRAINT usuario_orden_trabajo_pk PRIMARY KEY (id_usuario_orden_trabajo);


--
-- TOC entry 2936 (class 2606 OID 31321)
-- Name: usuario usuario_pk; Type: CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.usuario
    ADD CONSTRAINT usuario_pk PRIMARY KEY (id_usuario);


--
-- TOC entry 2951 (class 2606 OID 31456)
-- Name: auth_assignment auth_assignment_pkey; Type: CONSTRAINT; Schema: public; Owner: demo
--

ALTER TABLE ONLY public.auth_assignment
    ADD CONSTRAINT auth_assignment_pkey PRIMARY KEY (item_name, user_id);


--
-- TOC entry 2949 (class 2606 OID 31441)
-- Name: auth_item_child auth_item_child_pkey; Type: CONSTRAINT; Schema: public; Owner: demo
--

ALTER TABLE ONLY public.auth_item_child
    ADD CONSTRAINT auth_item_child_pkey PRIMARY KEY (parent, child);


--
-- TOC entry 2946 (class 2606 OID 31430)
-- Name: auth_item auth_item_pkey; Type: CONSTRAINT; Schema: public; Owner: demo
--

ALTER TABLE ONLY public.auth_item
    ADD CONSTRAINT auth_item_pkey PRIMARY KEY (name);


--
-- TOC entry 2944 (class 2606 OID 31422)
-- Name: auth_rule auth_rule_pkey; Type: CONSTRAINT; Schema: public; Owner: demo
--

ALTER TABLE ONLY public.auth_rule
    ADD CONSTRAINT auth_rule_pkey PRIMARY KEY (name);


--
-- TOC entry 2942 (class 2606 OID 31414)
-- Name: migration migration_pkey; Type: CONSTRAINT; Schema: public; Owner: demo
--

ALTER TABLE ONLY public.migration
    ADD CONSTRAINT migration_pkey PRIMARY KEY (version);


--
-- TOC entry 2952 (class 1259 OID 31463)
-- Name: idx-auth_assignment-user_id; Type: INDEX; Schema: public; Owner: demo
--

CREATE INDEX "idx-auth_assignment-user_id" ON public.auth_assignment USING btree (user_id);


--
-- TOC entry 2947 (class 1259 OID 31464)
-- Name: idx-auth_item-type; Type: INDEX; Schema: public; Owner: demo
--

CREATE INDEX "idx-auth_item-type" ON public.auth_item USING btree (type);


--
-- TOC entry 2967 (class 2606 OID 31180)
-- Name: historial_estado_archivo historial_estado_archivo_fk; Type: FK CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.historial_estado_archivo
    ADD CONSTRAINT historial_estado_archivo_fk FOREIGN KEY (id_historial_estado_orden_trabajo) REFERENCES ordenes_trabajo.historial_estado_orden_trabajo(id_historial_estado_orden_trabajo);


--
-- TOC entry 2968 (class 2606 OID 31185)
-- Name: historial_estado_archivo historial_estado_archivo_fk_1; Type: FK CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.historial_estado_archivo
    ADD CONSTRAINT historial_estado_archivo_fk_1 FOREIGN KEY (id_archivo) REFERENCES ordenes_trabajo.archivo(id_archivo);


--
-- TOC entry 2962 (class 2606 OID 31215)
-- Name: historial_estado_orden_trabajo historial_estado_orden_trabajo_fk; Type: FK CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.historial_estado_orden_trabajo
    ADD CONSTRAINT historial_estado_orden_trabajo_fk FOREIGN KEY (id_ordenes_trabajo) REFERENCES ordenes_trabajo.ordenes_trabajo(id_ordenes_trabajo);


--
-- TOC entry 2961 (class 2606 OID 31146)
-- Name: historial_estado_orden_trabajo historial_orden_trabajo_fk; Type: FK CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.historial_estado_orden_trabajo
    ADD CONSTRAINT historial_orden_trabajo_fk FOREIGN KEY (id_estado) REFERENCES ordenes_trabajo.estado(id_estado);


--
-- TOC entry 2963 (class 2606 OID 31345)
-- Name: inmueble inmueble_fk; Type: FK CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.inmueble
    ADD CONSTRAINT inmueble_fk FOREIGN KEY (id_sucursal) REFERENCES ordenes_trabajo.sucursal(id_sucursal);


--
-- TOC entry 2964 (class 2606 OID 31500)
-- Name: inmueble inmueble_sucursalfk; Type: FK CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.inmueble
    ADD CONSTRAINT inmueble_sucursalfk FOREIGN KEY (id_sucursal) REFERENCES ordenes_trabajo.sucursal(id_sucursal);


--
-- TOC entry 2976 (class 2606 OID 31512)
-- Name: modificaciones_ot modificaciones_ot_fk; Type: FK CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.modificaciones_ot
    ADD CONSTRAINT modificaciones_ot_fk FOREIGN KEY (id_ordenes_trabajo) REFERENCES ordenes_trabajo.ordenes_trabajo(id_ordenes_trabajo);


--
-- TOC entry 2960 (class 2606 OID 31476)
-- Name: ordenes_trabajo ordenes_trabajo_asignado_fk; Type: FK CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.ordenes_trabajo
    ADD CONSTRAINT ordenes_trabajo_asignado_fk FOREIGN KEY (id_usuario_asignado) REFERENCES ordenes_trabajo.usuario(id_usuario);


--
-- TOC entry 2957 (class 2606 OID 31225)
-- Name: ordenes_trabajo ordenes_trabajo_fk; Type: FK CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.ordenes_trabajo
    ADD CONSTRAINT ordenes_trabajo_fk FOREIGN KEY (id_historial_estado_orden_trabajo) REFERENCES ordenes_trabajo.historial_estado_orden_trabajo(id_historial_estado_orden_trabajo);


--
-- TOC entry 2958 (class 2606 OID 31230)
-- Name: ordenes_trabajo ordenes_trabajo_inmueble_fk; Type: FK CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.ordenes_trabajo
    ADD CONSTRAINT ordenes_trabajo_inmueble_fk FOREIGN KEY (id_inmueble) REFERENCES ordenes_trabajo.inmueble(id_inmueble);


--
-- TOC entry 2959 (class 2606 OID 31235)
-- Name: ordenes_trabajo ordenes_trabajo_tipo_trabajo_fk; Type: FK CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.ordenes_trabajo
    ADD CONSTRAINT ordenes_trabajo_tipo_trabajo_fk FOREIGN KEY (id_tipo_trabajo) REFERENCES ordenes_trabajo.tipo_trabajo(id_tipo_trabajo);


--
-- TOC entry 2970 (class 2606 OID 31340)
-- Name: persona persona_fk; Type: FK CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.persona
    ADD CONSTRAINT persona_fk FOREIGN KEY (id_sucursal) REFERENCES ordenes_trabajo.sucursal(id_sucursal);


--
-- TOC entry 2971 (class 2606 OID 31495)
-- Name: persona persona_sucursalfk; Type: FK CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.persona
    ADD CONSTRAINT persona_sucursalfk FOREIGN KEY (id_sucursal) REFERENCES ordenes_trabajo.sucursal(id_sucursal);


--
-- TOC entry 2969 (class 2606 OID 31330)
-- Name: usuario usuario_fk; Type: FK CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.usuario
    ADD CONSTRAINT usuario_fk FOREIGN KEY (id_persona) REFERENCES ordenes_trabajo.persona(id_persona);


--
-- TOC entry 2965 (class 2606 OID 31240)
-- Name: usuario_orden_trabajo usuario_orden_trabajo_fk; Type: FK CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.usuario_orden_trabajo
    ADD CONSTRAINT usuario_orden_trabajo_fk FOREIGN KEY (id_ordenes_trabajo) REFERENCES ordenes_trabajo.ordenes_trabajo(id_ordenes_trabajo);


--
-- TOC entry 2966 (class 2606 OID 31465)
-- Name: usuario_orden_trabajo usuario_orden_trabajo_usuario_fk; Type: FK CONSTRAINT; Schema: ordenes_trabajo; Owner: demo
--

ALTER TABLE ONLY ordenes_trabajo.usuario_orden_trabajo
    ADD CONSTRAINT usuario_orden_trabajo_usuario_fk FOREIGN KEY (id_usuario) REFERENCES ordenes_trabajo.usuario(id_usuario);


--
-- TOC entry 2975 (class 2606 OID 31457)
-- Name: auth_assignment auth_assignment_item_name_fkey; Type: FK CONSTRAINT; Schema: public; Owner: demo
--

ALTER TABLE ONLY public.auth_assignment
    ADD CONSTRAINT auth_assignment_item_name_fkey FOREIGN KEY (item_name) REFERENCES public.auth_item(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2974 (class 2606 OID 31447)
-- Name: auth_item_child auth_item_child_child_fkey; Type: FK CONSTRAINT; Schema: public; Owner: demo
--

ALTER TABLE ONLY public.auth_item_child
    ADD CONSTRAINT auth_item_child_child_fkey FOREIGN KEY (child) REFERENCES public.auth_item(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2973 (class 2606 OID 31442)
-- Name: auth_item_child auth_item_child_parent_fkey; Type: FK CONSTRAINT; Schema: public; Owner: demo
--

ALTER TABLE ONLY public.auth_item_child
    ADD CONSTRAINT auth_item_child_parent_fkey FOREIGN KEY (parent) REFERENCES public.auth_item(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2972 (class 2606 OID 31431)
-- Name: auth_item auth_item_rule_name_fkey; Type: FK CONSTRAINT; Schema: public; Owner: demo
--

ALTER TABLE ONLY public.auth_item
    ADD CONSTRAINT auth_item_rule_name_fkey FOREIGN KEY (rule_name) REFERENCES public.auth_rule(name) ON UPDATE CASCADE ON DELETE SET NULL;


-- Completed on 2020-09-14 12:32:19 -03

--
-- PostgreSQL database dump complete
--

