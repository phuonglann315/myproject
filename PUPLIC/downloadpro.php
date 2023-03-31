<?php
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();
if (isset($_GET['IDPR'])) {
    $IDPR = $_GET['IDPR'];
    $query = "select *
                    from (select NAMEPR,PRICE,BRIEFSUM,CREATEDATE,QUANTITY ,DESCRIPTION,NAMEBR,PRODUCT.IDBR AS IDBR,NAMECTGR,COLOR,
            
                     [STT]=  CASE
                     when DATEDIFF(MONTH,CREATEDATE,getdate())<1 then 'NEW'
                     when DATEDIFF(MONTH,CREATEDATE,getdate())=3 then '20%'
                     when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then '25%'
                     when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then '30%'
                             end ,
                     [NEWPRICE]=  CASE
                     when DATEDIFF(MONTH,CREATEDATE,getdate()) <3 then PRICE
                    when DATEDIFF(MONTH,CREATEDATE,getdate()) =3 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.2) AS decimal(7,0))
                     when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.25) AS decimal(7,0))
                     when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.3) AS decimal(7,0))                      
                             end 
                             from PRODUCT 
                            inner join BRAND on PRODUCT.IDBR=BRAND.IDBR
                            inner join CATEGORY on PRODUCT.IDCTGR=CATEGORY.IDCTGR
                     inner join IMAGES I on PRODUCT.IDPR=I.IDPR
                                       where PRODUCT.IDPR=? ) T ";
    $param = [$IDPR];
    $stmt = $dao->DMLParam($query, $param);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $NAMEPR = $row['NAMEPR'];
    $DESCRIPTION = $row['DESCRIPTION'];
    $BRIEFSUM = $row['BRIEFSUM'];
    $STT = $row['STT'];
    $NEWPRICE = $row['NEWPRICE'];
    $NAMEBR = $row['NAMEBR'];
    $IDBR = $row['IDBR'];
    $NAMECTGR = $row['NAMECTGR'];
    $COLOR = $row['COLOR'];
    $filename = 'demo.doc';
    header("Content-Type: application/force-download");
    header("Content-Disposition: attachment; filename=" . basename($filename));
    header("Content-Description: File Transfer");
    @readfile($filename);

    $content = '<html xmlns:v="urn:schemas-microsoft-com:vml" '
        . 'xmlns:o="urn:schemas-microsoft-com:office:office" '
        . 'xmlns:w="urn:schemas-microsoft-com:office:word" '
        . 'xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"= '
        . 'xmlns="http://www.w3.org/TR/REC-html40">'
        . '<head><meta http-equiv="Content-Type" content="text/html; charset=Windows-1252">'
        . '<title></title>'
        . '<!--[if gte mso 9]>'
        . '<xml>'
        . '<w:WordDocument>'
        . '<w:View>Print'
        . '<w:Zoom>100'
        . '<w:DoNotOptimizeForBrowser/>'
        . '</w:WordDocument>'
        . '</xml>'
        . '<![endif]-->'
        . '<style>
        @page
        {
            font-family: Arial;
            size:215.9mm 279.4mm;  /* A4 */
            margin:14.2mm 17.5mm 14.2mm 16mm; /* Margins: 2.5 cm on each side */
        }
        h2 { font-family: Arial; font-size: 18px; text-align:center; }
        p.para {font-family: Arial; font-size: 13.5px; text-align: justify;}
        </style>'
        . '
 
<li><span> Product Name: &nbsp;</span>' . $NAMEPR . '</li>   
<li><span> Product Type: &nbsp;</span>' . $NAMECTGR . '</li>
<li><span>Brand: &nbsp;</span>' . $NAMEBR . '</li>
<li><span>Product Code: &nbsp;</span> ' . $IDPR . '</li>  
<li><span>Price: &nbsp;</span> ' . $NEWPRICE . '</li>  
<li><span>Description: &nbsp;</span> ' . $DESCRIPTION . '</li>                                                          
<li><span>Sales Package: &nbsp;</span> 1</li>                                                            
<li><span>Combo: &nbsp;</span> Single</li>                                                            
';

    echo $content;

} else {
    header("location:HOME.php");
}


?>
