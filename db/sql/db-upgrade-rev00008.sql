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
-- # KD: Add payments tables
-- #############################################################################

-- # ---------------------------------------------------------------------- # --
-- # Tables: [p57b_billing.payments, p57b_billing.invoices, p57b_billing.payment_notifications]
-- # ---------------------------------------------------------------------- # --

DROP TABLE IF EXISTS "p57b_billing"."payments";

CREATE TABLE "p57b_billing"."payments"
(
    "id"            serial PRIMARY KEY,
    "timestamp"     timestamp without time zone DEFAULT now(),
    "oid"           text         NOT NULL,
    "payment_data"  text         NULL,
    "status"        varchar(255) NOT NULL,
    "amount"        bigint       NOT NULL,
    "psp_reference" VARCHAR
);
ALTER TABLE "p57b_billing"."payments"
    OWNER TO p57b_bill;

CREATE INDEX idb_payments_idx_timestamp
    ON "p57b_billing"."payments" ("timestamp");



DROP TABLE IF EXISTS "p57b_billing"."invoices";

CREATE TABLE "p57b_billing"."invoices"
(
    "id"             serial PRIMARY KEY,
    "payment_id"     INTEGER,
    "invoice_data"   text         NULL,
    "invoice_number" varchar(255) NOT NULL,
    "amount"         bigint       NOT NULL,
    "timestamp"      timestamp without time zone DEFAULT now()
);

ALTER TABLE "p57b_billing"."invoices"
    OWNER TO p57b_bill;

CREATE INDEX invoices_idx_timestamp
    ON "p57b_billing"."invoices" ("timestamp");



DROP TABLE IF EXISTS "p57b_billing"."payment_notifications";

CREATE TABLE "p57b_billing"."payment_notification"
(
    "id"   serial PRIMARY KEY,
    "data" text NOT NULL
);

ALTER TABLE "p57b_billing"."payment_notification"
    OWNER TO p57b_bill;



-- #############################################################################
-- #                               End of file                                 #
-- #############################################################################
