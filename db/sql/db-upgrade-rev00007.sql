-- # * ********************************************************************* *
-- # *                                                                       *
-- # *   Billing Portal                                                      *
-- # *   This file is part of billingportal. This project may be found at:   *
-- # *   https://github.com/IdentityBank/Php_billingportal.                  *
-- # *                                                                       *
-- # *   Copyright (C) 2020 by Identity Bank. All Rights Reserved.           *
-- # *   https://www.identitybank.eu - You belong to you                     *
-- # *                                                                       *
-- # *   This program is free software: you can redistribute it and/or       *
-- # *   modify it under the terms of the GNU Affero General Public          *
-- # *   License as published by the Free Software Foundation, either        *
-- # *   version 3 of the License, or (at your option) any later version.    *
-- # *                                                                       *
-- # *   This program is distributed in the hope that it will be useful,     *
-- # *   but WITHOUT ANY WARRANTY; without even the implied warranty of      *
-- # *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the        *
-- # *   GNU Affero General Public License for more details.                 *
-- # *                                                                       *
-- # *   You should have received a copy of the GNU Affero General Public    *
-- # *   License along with this program. If not, see                        *
-- # *   https://www.gnu.org/licenses/.                                      *
-- # *                                                                       *
-- # * ********************************************************************* *

-- #############################################################################
-- # DB migration file
-- #############################################################################

-- #############################################################################
-- # AT: Create Tables for business billing
-- #############################################################################

DROP TABLE IF EXISTS "p57b_billing"."action_cost";
DROP TABLE IF EXISTS "p57b_billing"."business_package";
DROP TABLE IF EXISTS "p57b_billing"."package";
DROP TABLE IF EXISTS "p57b_billing"."business";
DROP TABLE IF EXISTS "p57b_billing"."billing_audit_logs";

-- # ---------------------------------------------------------------------- # --
-- # Table: p57b_billing.action_cost
-- # ---------------------------------------------------------------------- # --

CREATE TABLE "p57b_billing"."action_cost"
(
    "id"          serial PRIMARY KEY,
    "credits"     integer      NOT NULL,
    "action_type" varchar(255) NOT NULL,
    "action_name" varchar(255) NOT NULL
);

ALTER TABLE "p57b_billing"."action_cost"
    OWNER TO p57b_bill;

-- # ---------------------------------------------------------------------- # --
-- # Table: p57b_billing.business_package
-- # ---------------------------------------------------------------------- # --

CREATE TABLE "p57b_billing"."business_package"
(
    "id"                 serial PRIMARY KEY,
    "business_id"        varchar(1024) not null,
    "package_id"         integer       not null,
    "payment_log_id"     integer,
    "credits"            integer       NOT NULL,
    "base_credits"       integer       not null,
    "additional_credits" integer default 0,
    "duration"           integer       not null,
    "start_date"         timestamp     not null,
    "end_date"           timestamp     not null,
    "last_payment"       timestamp,
    "next_payment"       timestamp     not null
);

ALTER TABLE "p57b_billing"."business_package"
    OWNER TO p57b_bill;

CREATE UNIQUE INDEX billing_business_package_business_id ON "p57b_billing"."business_package" ("business_id");

-- # ---------------------------------------------------------------------- # --
-- # Table: p57b_billing.package
-- # ---------------------------------------------------------------------- # --

CREATE TABLE "p57b_billing"."package"
(
    "id"       serial PRIMARY KEY,
    "order"    integer default 100,
    "credits"  integer      NOT NULL,
    "duration" integer      NOT NULL,
    "name"     varchar(255) NOT NULL,
    "price"    varchar(255) NOT NULL,
    "currency" varchar(255) NOT NULL,
    "image"    varchar(255),
    "included" text,
    "excluded" text,
    "tag"      text,
    "active"   integer default 1
);

ALTER TABLE "p57b_billing"."package"
    OWNER TO p57b_bill;

-- # ---------------------------------------------------------------------- # --
-- # Table: p57b_billing.business
-- # ---------------------------------------------------------------------- # --

CREATE TABLE "p57b_billing"."business"
(
    "id"      serial PRIMARY KEY,
    "bid"     varchar(1024) NOT null,
    "data"    text          NOT NULL,
    "credits" text          NOT NULL
);

CREATE UNIQUE INDEX business_idx_bid ON "p57b_billing"."business" ("bid");

ALTER TABLE "p57b_billing"."business"
    OWNER TO p57b_bill;

-- # ---------------------------------------------------------------------- # --
-- # Table: p57b_billing.billing_audit_logs
-- # ---------------------------------------------------------------------- # --

CREATE TABLE "p57b_billing"."billing_audit_logs"
(
    "id"          serial PRIMARY KEY,
    "action_type" varchar(255)  NOT NULL,
    "action_name" varchar(255)  NOT NULL,
    "action_date" timestamp     not null,
    "bid"         varchar(1024) NOT null,
    "transfer"    varchar(255)  not null,
    "credits"     integer       NOT NULL
);

CREATE INDEX billing_audit_logs_idx_bid ON "p57b_billing"."billing_audit_logs" ("bid");

ALTER TABLE "p57b_billing"."billing_audit_logs"
    OWNER TO p57b_bill;

-- #############################################################################
-- #                               End of file                                 #
-- #############################################################################
