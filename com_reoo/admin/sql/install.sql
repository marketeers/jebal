
DELETE FROM `nn8j7_users` WHERE `id` in (SELECT `userid` FROM `nn8j7_sscustomers`);

DROP TABLE IF EXISTS `nn8j7_sscategories`;
CREATE TABLE IF NOT EXISTS `nn8j7_sscategories` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `TempID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `nn8j7_sscategoriestemp`;
CREATE TABLE IF NOT EXISTS `nn8j7_sscategoriestemp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Name_trans` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `nn8j7_sscities`;
CREATE TABLE IF NOT EXISTS `nn8j7_sscities` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `ProvinceID` bigint(20) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `TempID` int(11) NOT NULL,
  `ProvinceTempID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


DROP TABLE IF EXISTS `nn8j7_sscitiestemp`;
CREATE TABLE IF NOT EXISTS `nn8j7_sscitiestemp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Name_trans` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ProvinceID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



DROP TABLE IF EXISTS `nn8j7_sscompanies`;
CREATE TABLE IF NOT EXISTS `nn8j7_sscompanies` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;



INSERT INTO `nn8j7_sscompanies` (`ID`, `Name`) VALUES
(1, 'Bridge'),
(2, 'Personal'),
(3, 'Website');

DROP TABLE IF EXISTS `nn8j7_ssconstructionphasedetails`;
CREATE TABLE IF NOT EXISTS `nn8j7_ssconstructionphasedetails` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `PhaseID` bigint(20) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `nn8j7_ssconstructionphases`;
CREATE TABLE IF NOT EXISTS `nn8j7_ssconstructionphases` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `nn8j7_sscontracts`;
CREATE TABLE IF NOT EXISTS `nn8j7_sscontracts` (
  `ID` bigint(20) NOT NULL,
  `CustomerID` bigint(20) NOT NULL,
  `UnitID` bigint(20) NOT NULL,
  `TotalValue` int(11) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `nn8j7_sscustomers`;
CREATE TABLE IF NOT EXISTS `nn8j7_sscustomers` (
  `ID` bigint(20) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `NameInArabic` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `nn8j7_ssfinishinglevels`;
CREATE TABLE IF NOT EXISTS `nn8j7_ssfinishinglevels` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `nn8j7_ssfloors`;
CREATE TABLE IF NOT EXISTS `nn8j7_ssfloors` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `TempID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `nn8j7_ssfloorstemp`;
CREATE TABLE IF NOT EXISTS `nn8j7_ssfloorstemp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Name_trans` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `nn8j7_ssinstallments`;
CREATE TABLE IF NOT EXISTS `nn8j7_ssinstallments` (
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


DROP TABLE IF EXISTS `nn8j7_ssmodificationdetails`;
CREATE TABLE IF NOT EXISTS `nn8j7_ssmodificationdetails` (
  `ID` bigint(20) NOT NULL,
  `ModificationRequest_ID` bigint(20) NOT NULL,
  `ModificationData` text CHARACTER SET utf8 NOT NULL,
  `PossibiltyToDo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ModificationStatus` bigint(20) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `nn8j7_ssmodificationrequest`;
CREATE TABLE IF NOT EXISTS `nn8j7_ssmodificationrequest` (
  `ID` bigint(20) NOT NULL,
  `UnitID` bigint(20) NOT NULL,
  `Subject` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ModificationStatus` bigint(20) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `nn8j7_ssmodificationstatus`;
CREATE TABLE IF NOT EXISTS `nn8j7_ssmodificationstatus` (
  `ID` bigint(20) NOT NULL,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Name_trans` varchar(255) CHARACTER SET utf8 NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `nn8j7_sspayments`;
CREATE TABLE IF NOT EXISTS `nn8j7_sspayments` (
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

DROP TABLE IF EXISTS `nn8j7_sspimages`;
CREATE TABLE IF NOT EXISTS `nn8j7_sspimages` (
  `ID` bigint(20) NOT NULL,
  `Image` bigint(20) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `nn8j7_ssprojects`;
CREATE TABLE IF NOT EXISTS `nn8j7_ssprojects` (
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

DROP TABLE IF EXISTS `nn8j7_ssprovinces`;
CREATE TABLE IF NOT EXISTS `nn8j7_ssprovinces` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `TempID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `nn8j7_ssprovincestemp`;
CREATE TABLE IF NOT EXISTS `nn8j7_ssprovincestemp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Name_trans` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `nn8j7_ssregions`;
CREATE TABLE IF NOT EXISTS `nn8j7_ssregions` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `CityID` bigint(20) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `TempID` int(11) NOT NULL,
  `CityTempID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `nn8j7_ssregionstemp`;
CREATE TABLE IF NOT EXISTS `nn8j7_ssregionstemp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Name_trans` varchar(255) CHARACTER SET utf8 NOT NULL,
  `CityID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `nn8j7_ssreservationstatus`;
CREATE TABLE IF NOT EXISTS `nn8j7_ssreservationstatus` (
  `ID` bigint(20) NOT NULL,
  `Name_ara` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Name_en` varchar(100) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `nn8j7_sssubcategories`;
CREATE TABLE IF NOT EXISTS `nn8j7_sssubcategories` (
  `ID` bigint(20) NOT NULL,
  `Name_trans` varchar(100) NOT NULL,
  `CategoryID` bigint(20) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `IsExists` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `nn8j7_sstemp`;
CREATE TABLE IF NOT EXISTS `nn8j7_sstemp` (
  `ID` int(11) NOT NULL,
  KEY `ID` (`ID`),
  KEY `ID_2` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `nn8j7_ssunits`;
CREATE TABLE IF NOT EXISTS `nn8j7_ssunits` (
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

