 <?php
   $objConnect=oci_connect("DEVELOPERS","Test1234","10.99.99.20:1525/ORCLPDB",'AL32UTF8');
  // $objConnect=@oci_connect("DEVELOPERS2","RMLIT2024DEV","192.168.172.61:1521/ORCL");
  //  $objConnect = oci_connect("TESTDB", "Test123", "192.168.172.61:1521/ORCL",'AL32UTF8');
  //  $objConnect = oci_connect("TESTDB", "Test123", "localhost:1521/ORCL");
   //$objConnect=oci_connect("DEVELOPERS2","Test1234","192.168.172.61:1521/xe");
// $objConnect = oci_connect("DEVELOPERS", "Test1234", "localhost:1521/ORCL",);
    if (!$objConnect){
      echo 'Failed to connect to Oracle';
    }
        
?>