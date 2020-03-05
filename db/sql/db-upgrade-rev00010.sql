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
-- # KD: Add Actions to action_cost and add billing type to business package
-- #############################################################################

-- # ---------------------------------------------------------------------- # --
-- # Table: p57b_billing.action_cost
-- # ---------------------------------------------------------------------- # --

INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Bandwidth', 1, '');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Processing', 1, '');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, '');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Databases', 1, '');

INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Processing', 1, 'getCountAllPackages');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Processing', 1, 'getPackages');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Processing', 1, 'createInvoice');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Processing', 1, 'logPayment');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Processing', 1, 'getLastInvoiceNumber');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Processing', 1, 'getPaymentsForOrganization');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Processing', 1, 'getInvoiceForPayment');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Processing', 1, 'getCountAllBillingAuditLogsForBusiness');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Processing', 1, 'addBillingAuditLog');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Processing', 1, 'addBusiness');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Processing', 1, 'getBusinessPackage');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Processing', 1, 'assignPackageToBusiness');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Processing', 1, 'updateBusinessPackage');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Processing', 1, 'findCountAllBusinessPackage');

INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'createAccountMetadata');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'getAccountMetadata');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'setAccountMetadata');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'deleteAccountMetadata');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Databases', 1, 'deleteItem');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Databases', 1, 'getItem');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Databases', 1, 'putItem');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Databases', 1, 'updateItem');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Databases', 1, 'dropCreateAccount');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Databases', 1, 'updateDataTypes');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Databases', 1, 'count');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Databases', 1, 'countAllItems');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Databases', 1, 'putItems');

INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'deleteAccount');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'createAccountChangeRequest');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'deleteAccountChangeRequest');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'dropCreateAccountChangeRequest');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'getAllAccountCRs');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'getAccountCR');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'getAccountCRbyStatus');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'addAccountCRbyUserId');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'updateAccountCR');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'findAccountCRItems');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'findCountAllAccountCRItems');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'countAllAccountCRItems');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'createAccountStatus');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'getAllAccountSTs');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'getAccountSTbyUserId');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'getAccountSTbyStatus');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'deleteAccountStatus');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'dropCreateAccountStatus');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'deleteAccountSTbyUserId');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'addAccountSTbyUserId');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'updateAccountSTbyUserId');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'setRelationBusiness2People');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'checkRelationBusiness2People');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'deleteRelationBusiness2People');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'getRelatedPeoples');
INSERT INTO "p57b_billing"."action_cost"("action_type", "credits", "action_name") VALUES ('Storage', 1, 'getRelatedBusinesses');

-- # ---------------------------------------------------------------------- # --
-- # Table: p57b_billing.business_package
-- # ---------------------------------------------------------------------- # --

ALTER TABLE "p57b_billing"."business_package" ADD COLUMN
    "billing_type" varchar(50) default 'business';

-- #############################################################################
-- #                               End of file                                 #
-- #############################################################################
