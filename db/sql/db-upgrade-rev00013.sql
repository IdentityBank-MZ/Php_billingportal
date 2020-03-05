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
-- # SR: Alter Tables for business billing
-- #############################################################################

-- # ---------------------------------------------------------------------- # --
-- # Table: p57b_billing.business_package
-- # ---------------------------------------------------------------------- # --

ALTER TABLE "p57b_billing"."business_package" ALTER COLUMN "start_date" DROP NOT NULL;
ALTER TABLE "p57b_billing"."business_package" ALTER COLUMN "end_date" DROP NOT NULL;
ALTER TABLE "p57b_billing"."business_package" ALTER COLUMN "next_payment" DROP NOT NULL;
ALTER TABLE "p57b_billing"."business_package" ALTER COLUMN "last_payment" DROP NOT NULL;

-- #############################################################################
-- #                               End of file                                 #
-- #############################################################################
