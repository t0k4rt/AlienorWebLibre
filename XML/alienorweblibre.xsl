<?xml version="1.0" encoding="iso-8859-1"?>
<!-- DWXMLSource="/alienorweblibre/XML/exportAlienorWebLibre.xml" -->
<!DOCTYPE xsl:stylesheet  [
	<!ENTITY nbsp   "&#160;">
	<!ENTITY copy   "&#169;">
	<!ENTITY reg    "&#174;">
	<!ENTITY trade  "&#8482;">
	<!ENTITY mdash  "&#8212;">
	<!ENTITY ldquo  "&#8220;">
	<!ENTITY rdquo  "&#8221;"> 
	<!ENTITY pound  "&#163;">
	<!ENTITY yen    "&#165;">
	<!ENTITY euro   "&#8364;">
]>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="text" encoding="iso-8859-1" />
    <xsl:template match="/">
        <OBJET IDENTIFIANT_NATIONAL="">
            <DESIGNATION>
                <DISCIPLINE RANG=""><xsl:value-of select="PATRIMOINE/OBJET/DISCIPLINE"/></DISCIPLINE>
                <DOMAINE RANG=""><xsl:value-of select="PATRIMOINE/OBJET/DISCIPLINE"/></DOMAINE>
                <DENOMINATION RANG=""><xsl:value-of select="PATRIMOINE/OBJET/DENOMINATION"/></DENOMINATION>
                <TITRE RANG=""><xsl:value-of select="PATRIMOINE/OBJET/TITRE"/></TITRE>
                <APPELLATION RANG=""><xsl:value-of select="PATRIMOINE/OBJET/APPELLATION"/></APPELLATION>
                <VERNACULAIRE RANG=""><xsl:value-of select="PATRIMOINE/OBJET/VERNACULAIRE"/></VERNACULAIRE>
                <NB_EXEMPLAIRE><xsl:value-of select="PATRIMOINE/OBJET/EXEMPLAIRE"/></NB_EXEMPLAIRE>
                <TYPOLOGIE RANG=""><xsl:value-of select="PATRIMOINE/OBJET/TYPOLOGIE"/></TYPOLOGIE>
                <NUMERO_INVENTAIRE RANG=""><xsl:value-of select="PATRIMOINE/OBJET/NUMERO_INVENTAIRE"/></NUMERO_INVENTAIRE>
                <TAXONOMIE><xsl:value-of select="PATRIMOINE/OBJET/TAXONOMIE"/></TAXONOMIE>
            </DESIGNATION>
            <PROVENANCE>
                <LIEUX_DECOUVERTE SITE=""></LIEUX_DECOUVERTE>
                <DATE_DECOUVERTE>
                    <DATE_PATRIMONIALE>
                        <AFFIXE><xsl:value-of select="PATRIMOINE/OBJET/TXT_DATE_DECOUVERTE"/></AFFIXE>
                        <DATE_DEBUT><xsl:value-of select="PATRIMOINE/OBJET/DEB_DATE_DECOUVERTE"/></DATE_DEBUT>
                        <DATE_FIN><xsl:value-of select="PATRIMOINE/OBJET/FIN_DATE_DECOUVERTE"/></DATE_FIN>
                    </DATE_PATRIMONIALE>
                </DATE_DECOUVERTE>
                <PRECISION_DECOUVERTE><xsl:value-of select="PATRIMOINE/OBJET/PRECISION_DECOUVERTE"/></PRECISION_DECOUVERTE>
            </PROVENANCE>
            <DESCRIPTION>
                <MATIERE RANG=""><xsl:value-of select="PATRIMOINE/OBJET/MATIERE"/></MATIERE>
                <TECHNIQUE RANG=""><xsl:value-of select="PATRIMOINE/OBJET/MATIERE"/></TECHNIQUE>
                <DIMENSIONS_FORMES RANG=""><xsl:value-of select="PATRIMOINE/OBJET/DIMENSIONS_FORMES"/></DIMENSIONS_FORMES>
                <TYPE_INSCRIPTION><xsl:value-of select="PATRIMOINE/OBJET/TYPE_INSCRIPTION"/></TYPE_INSCRIPTION>
            </DESCRIPTION>
            <EXECUTION>
                <SIECLE_MILLENAIRE><xsl:value-of select="PATRIMOINE/OBJET/SIECLE_MILLENAIRE"/></SIECLE_MILLENAIRE>
                <AUTEUR ETAT_CIVIL="" RANG="1">
                    <ETAT_CIVIL></ETAT_CIVIL>
                    <ROLE><xsl:value-of select="PATRIMOINE/OBJET/ROLE"/></ROLE>
                </AUTEUR>
            </EXECUTION>
            <USAGE></USAGE>
            <ADMINISTRATION>
                <LOCALISATION></LOCALISATION>
                <MODE_ACQUISITION></MODE_ACQUISITION>
                <ANCIENNE_APPARTENANCE ETAT_CIVIL="" RANG="">
                    <ETAT_CIVIL></ETAT_CIVIL>
                </ANCIENNE_APPARTENANCE>
                <PROPRIETAIRE ETAT_CIVIL="">
                    <ETAT_CIVIL></ETAT_CIVIL>
                    <TYPE_PROPRIETE></TYPE_PROPRIETE>
                </PROPRIETAIRE>
                <SERVICE_GESTIONNAIRE ETAT_CIVIL=""></SERVICE_GESTIONNAIRE>
            </ADMINISTRATION>
            <DOSSIER>
                <PHOTOGRAPHIE IDENTIFIANT="" RANG="">
                    <IDENTIFIANT></IDENTIFIANT>
                    <PARAMETRE></PARAMETRE>
                </PHOTOGRAPHIE>
                <INTERNET IDENTIFIANT="" RANG="">
                    <IDENTIFIANT></IDENTIFIANT>
                    <PARAMETRE></PARAMETRE>
                </INTERNET>
            </DOSSIER>
            <GESTION> </GESTION>
            <INFORMATIQUE>
                <COPYRIGHT></COPYRIGHT>
                <FICHE_CREEE_LE></FICHE_CREEE_LE>
                <FICHE_CREEE_PAR></FICHE_CREEE_PAR>
                <MISE_A_JOUR></MISE_A_JOUR>
                <DATE_DIFFUSION></DATE_DIFFUSION>
                <CODEMUSEE></CODEMUSEE>
            </INFORMATIQUE>
        </OBJET>
    </xsl:template>
</xsl:stylesheet>
