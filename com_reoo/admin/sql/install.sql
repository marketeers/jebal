
DELETE FROM `cstm_users` WHERE `id` in (SELECT `userid` FROM `cstm_sscustomers`);

DROP TABLE IF EXISTS `cstm_sscategories`;
CREATE TABLE IF NOT EXISTS `cstm_sscategories` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `TempID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cstm_sscategoriestemp`;
CREATE TABLE IF NOT EXISTS `cstm_sscategoriestemp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Name_trans` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `cstm_sscities`;
CREATE TABLE IF NOT EXISTS `cstm_sscities` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `ProvinceID` bigint(20) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `TempID` int(11) NOT NULL,
  `ProvinceTempID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


DROP TABLE IF EXISTS `cstm_sscitiestemp`;
CREATE TABLE IF NOT EXISTS `cstm_sscitiestemp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Name_trans` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ProvinceID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



DROP TABLE IF EXISTS `cstm_sscompanies`;
CREATE TABLE IF NOT EXISTS `cstm_sscompanies` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;



INSERT INTO `cstm_sscompanies` (`ID`, `Name`) VALUES
(1, 'Bridge'),
(2, 'Personal'),
(3, 'Website');

DROP TABLE IF EXISTS `cstm_ssconstructionphasedetails`;
CREATE TABLE IF NOT EXISTS `cstm_ssconstructionphasedetails` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `PhaseID` bigint(20) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cstm_ssconstructionphases`;
CREATE TABLE IF NOT EXISTS `cstm_ssconstructionphases` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cstm_sscontracts`;
CREATE TABLE IF NOT EXISTS `cstm_sscontracts` (
  `ID` bigint(20) NOT NULL,
  `CustomerID` bigint(20) NOT NULL,
  `UnitID` bigint(20) NOT NULL,
  `TotalValue` int(11) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cstm_sscustomers`;
CREATE TABLE IF NOT EXISTS `cstm_sscustomers` (
  `ID` bigint(20) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `NameInArabic` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cstm_ssfinishinglevels`;
CREATE TABLE IF NOT EXISTS `cstm_ssfinishinglevels` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cstm_ssfloors`;
CREATE TABLE IF NOT EXISTS `cstm_ssfloors` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `TempID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cstm_ssfloorstemp`;
CREATE TABLE IF NOT EXISTS `cstm_ssfloorstemp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Name_trans` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `cstm_ssinstallments`;
CREATE TABLE IF NOT EXISTS `cstm_ssinstallments` (
  `ID` bigint(20) NOT NULL,
  `Type_trans` varchar(100) NOT NULL,
  `Amount` int(11) NOT NULL,
  `ContractID` bigint(20) NOT NULL,
  `Type` varchar(100) NOT NULL,
  `Date` datetime DEFAULT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cstm_ssmodificationdetails`;
CREATE TABLE IF NOT EXISTS `cstm_ssmodificationdetails` (
  `ID` bigint(20) NOT NULL,
  `ModificationRequest_ID` bigint(20) NOT NULL,
  `ModificationData` text CHARACTER SET utf8 NOT NULL,
  `PossibiltyToDo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ModificationStatus` bigint(20) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `cstm_ssmodificationrequest`;
CREATE TABLE IF NOT EXISTS `cstm_ssmodificationrequest` (
  `ID` bigint(20) NOT NULL,
  `UnitID` bigint(20) NOT NULL,
  `Subject` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ModificationStatus` bigint(20) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `cstm_ssmodificationstatus`;
CREATE TABLE IF NOT EXISTS `cstm_ssmodificationstatus` (
  `ID` bigint(20) NOT NULL,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Name_trans` varchar(255) CHARACTER SET utf8 NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `cstm_sspayments`;
CREATE TABLE IF NOT EXISTS `cstm_sspayments` (
  `ID` bigint(20) NOT NULL,
  `bankName_ara` varchar(100) NOT NULL,
  `Amount` int(11) NOT NULL,
  `Date` datetime DEFAULT NULL,
  `ContractID` bigint(20) NOT NULL,
  `InstallmentID` bigint(20) NOT NULL,
  `PaymentMethod` varchar(100) NOT NULL,
  `CheckDate` datetime DEFAULT NULL,
  `CheckNumber` int(11) NOT NULL,
  `bankName` varchar(100) NOT NULL,
  `PaymentMethod_trans` varchar(100) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cstm_sspimages`;
CREATE TABLE IF NOT EXISTS `cstm_sspimages` (
  `ID` bigint(20) NOT NULL,
  `Image` bigint(20) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cstm_ssprojects`;
CREATE TABLE IF NOT EXISTS `cstm_ssprojects` (
  `ID` bigint(20) NOT NULL,
  `Nebour_trans` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `ProjectNumber` varchar(50) NOT NULL,
  `RegionID` bigint(20) NOT NULL,
  `ConstructionPhaseID` bigint(20) NOT NULL,
  `ConstructionPhaseDetailID` bigint(20) NOT NULL,
  `IntialDeliveryDate` datetime DEFAULT NULL,
  `FinalDeliveryDate` datetime DEFAULT NULL,
  `Nebour` varchar(100) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `cstm_ssprovinces`;
CREATE TABLE IF NOT EXISTS `cstm_ssprovinces` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `TempID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cstm_ssprovincestemp`;
CREATE TABLE IF NOT EXISTS `cstm_ssprovincestemp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Name_trans` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `cstm_ssregions`;
CREATE TABLE IF NOT EXISTS `cstm_ssregions` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `CityID` bigint(20) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `TempID` int(11) NOT NULL,
  `CityTempID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cstm_ssregionstemp`;
CREATE TABLE IF NOT EXISTS `cstm_ssregionstemp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Name_trans` varchar(255) CHARACTER SET utf8 NOT NULL,
  `CityID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `cstm_ssreservationstatus`;
CREATE TABLE IF NOT EXISTS `cstm_ssreservationstatus` (
  `ID` bigint(20) NOT NULL,
  `Name_ara` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Name_en` varchar(100) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cstm_sssubcategories`;
CREATE TABLE IF NOT EXISTS `cstm_sssubcategories` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `CategoryID` bigint(20) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cstm_sstemp`;
CREATE TABLE IF NOT EXISTS `cstm_sstemp` (
  `ID` int(11) NOT NULL,
  KEY `ID` (`ID`),
  KEY `ID_2` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `cstm_ssunits`;
CREATE TABLE IF NOT EXISTS `cstm_ssunits` (
  `ID` bigint(20) NOT NULL,
  `PlotNumber` varchar(50) NOT NULL,
  `ProjectID` bigint(20) NOT NULL,
  `Area` int(11) NOT NULL,
  `UnitValue` int(11) NOT NULL,
  `HaveGarage` tinyint(4) NOT NULL,
  `GarageValue` int(11) NOT NULL,
  `TotalValue` int(11) NOT NULL,
  `CategoryID` bigint(20) NOT NULL,
  `SubcategoryID` bigint(20) NOT NULL,
  `FloorID` bigint(20) NOT NULL,
  `FinishingLevelID` bigint(20) NOT NULL,
  `ReservationStatusID` bigint(20) NOT NULL,
  `ConstructionPhaseID` bigint(20) NOT NULL,
  `ConstructionPhaseDetailID` bigint(20) NOT NULL,
  `PlotBoundaries` varchar(200) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

