DELETE FROM `nn8j7_users` WHERE `id` in (SELECT `userid` FROM `nn8j7_sscustomers`);
DROP TABLE IF EXISTS `nn8j7_sscategories`;
DROP TABLE IF EXISTS `nn8j7_sscategoriestemp`;
DROP TABLE IF EXISTS `nn8j7_sscities`;
DROP TABLE IF EXISTS `nn8j7_sscitiestemp`;
DROP TABLE IF EXISTS `nn8j7_sscompanies`;
DROP TABLE IF EXISTS `nn8j7_ssconstructionphasedetails`;
DROP TABLE IF EXISTS `nn8j7_ssconstructionphases`;
DROP TABLE IF EXISTS `nn8j7_sscontracts`;
DROP TABLE IF EXISTS `nn8j7_sscustomers`;
DROP TABLE IF EXISTS `nn8j7_ssfinishinglevels`;
DROP TABLE IF EXISTS `nn8j7_ssfloors`;
DROP TABLE IF EXISTS `nn8j7_ssfloorstemp`;
DROP TABLE IF EXISTS `nn8j7_ssinstallments`;
DROP TABLE IF EXISTS `nn8j7_ssmodificationdetails`;
DROP TABLE IF EXISTS `nn8j7_ssmodificationrequest`;
DROP TABLE IF EXISTS `nn8j7_ssmodificationstatus`;
DROP TABLE IF EXISTS `nn8j7_sspayments`;
DROP TABLE IF EXISTS `nn8j7_sspimages`;
DROP TABLE IF EXISTS `nn8j7_ssprojects`;
DROP TABLE IF EXISTS `nn8j7_ssprovinces`;
DROP TABLE IF EXISTS `nn8j7_ssprovincestemp`;
DROP TABLE IF EXISTS `nn8j7_ssregions`;
DROP TABLE IF EXISTS `nn8j7_ssregionstemp`;
DROP TABLE IF EXISTS `nn8j7_ssreservationstatus`;
DROP TABLE IF EXISTS `nn8j7_sssubcategories`;
DROP TABLE IF EXISTS `nn8j7_sstemp`;
DROP TABLE IF EXISTS `nn8j7_ssunits`;
