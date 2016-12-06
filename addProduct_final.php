<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentellela Alela! | </title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="../vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="../vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="../vendors/starrr/dist/starrr.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  

       
        <?php 
require_once('header.php');

?>

     <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
<?php


$flag=0;
if (isset($_POST['submitProduct'])){

  
  $message=NULL;

   if (empty($_POST['productName'])){
    $productName=FALSE;
    $message.='<p>You forgot to enter the product name!';
   }else
    $productName=$_POST['productName'];

   if (empty($_POST['productDescription'])){
    $productDescription=NULL;
   }else
    $productDescription=$_POST['productDescription'];

   if (empty($_POST['productPrice'])){
    $productPrice=0;
   }else{
    if (!is_numeric($_POST['productPrice'])){
     $message.='<p>The product price you entered is not numeric!';
    }else
     $productPrice=$_POST['productPrice'];
   }

   if (empty($_POST['dropdown_category'])){
    $dropdown_category=FALSE;
    $message.='<p>You forgot to enter the product Category!';
   }else
    $dropdown_category=$_POST['dropdown_category'];

   if (empty($_POST['dropdown_Subcategory'])){
    $dropdown_Subcategory=FALSE;
    $message.='<p>You forgot to enter the product Sub-Category!';
   }else
    $dropdown_Subcategory=$_POST['dropdown_Subcategory'];

  if (empty($_POST['minStock'])){
    $minStock=0;
   }else{
    if (!is_numeric($_POST['minStock'])){
     $message.='<p>The Stock you entered is not numeric!';
    }else
     $minStock=$_POST['minStock'];
   }


   if (empty($_POST['productImage'])){
    $productImage=NULL;
   }else
    $productImage=$_POST['productImage'];


    if (empty($_POST['S'])){
    $sizeS=NULL;
   }else
    $sizeS="S";

    if (empty($_POST['M'])){
    $sizeM=NULL;
   }else
    $sizeM="M";

    if (empty($_POST['L'])){  
    $sizeL=NULL;
   }else
    $sizeL="L";

     if (empty($_POST['noSize'])){
    $sizeNull=NULL;
   }else
    $sizeNull="Null";




  if(!isset($message)){
   
  
    require_once('../db_connect.php');


    $target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$name=basename( $_FILES["fileToUpload"]["name"]);
// // Check if image file is a actual image or fake image
// if(isset($_POST["submit"])) {
//     $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//     if($check !== false) {
//         echo "File is an image - " . $check["mime"] . ".";
//         $uploadOk = 1;
//     } else {
//         echo "File is not an image.";
//         $uploadOk = 0;
//     }
// }


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<font color='green'><b> The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded. </b></font>";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
    $query="insert into products (prod_name,prod_desc,prod_price,category,subcategory,image,status,min_stock) values ('{$productName}','{$productDescription}','{$productPrice}','{$dropdown_category}','{$dropdown_Subcategory}','{$name}','1','{$minStock}')";
    $result=mysqli_query($dbc,$query);
    $message="<b><p>Name: {$productName}<br>Description: {$productDescription}<br>Price: {$productPrice}<br> Category: {$dropdown_category}<br>Sub-Category: {$dropdown_Subcategory}<br>Minimun Stock: {$minStock}<br>added!</b>";
    $flag=1;



    $queryLatest="SELECT prod_id FROM products ORDER BY  prod_id DESC LIMIT 1";
    $resultLatest=mysqli_query($dbc,$queryLatest);
    while($rowLatest=mysqli_fetch_array($resultLatest,MYSQLI_ASSOC)){


      if(isset($_POST['S'])){
        $queryS="INSERT INTO size (prod_id,size) values('{$rowLatest['prod_id']}','{$sizeS}')";
        $resultS=mysqli_query($dbc,$queryS);

      }

      if(isset($_POST['M'])){
        $queryM="INSERT INTO size (prod_id,size) values('{$rowLatest['prod_id']}','{$sizeM}')";
        $resultM=mysqli_query($dbc,$queryM);
      }

      if(isset($_POST['L'])){
        $queryL="INSERT INTO size (prod_id,size) values('{$rowLatest['prod_id']}','{$sizeL}')";
        $resultL=mysqli_query($dbc,$queryL);
      }


    if(isset($_POST['noSize'])){
        $queryNull="INSERT INTO size (prod_id) values('{$rowLatest['prod_id']}')";
        $resultNull=mysqli_query($dbc,$queryNull);
      }



    }



  }


}/*End of main Submit conditional*/


?>

 <!-- page content -->

                  <?php
                    if(isset($message)){

                       echo '<font color="green">'.$message. '</font>';
                    }
                  ?>

                  <h3>Add New Product</h3>
                </div>
              </div>
              <div class="clearfix"></div>
              </div>

              <div class="row">

              <div class="col-md-6  col-xs-10 ">
                <div class="x_panel">
                 <div class="x_title">
                    <div class="x-content">
                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

                          <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name <span class="required">*</span>
                          </label>
                          <div class="ccol-md-9 col-sm-9 col-xs-12">
                            <input type="text" name="productName" size="20" maxleng="30" value="<?php if (isset($_POST['productName']) && !$flag) echo $_POST['productName']; ?>"  class="form-control col-md-9 col-sm-9 col-xs-12" required/>
                          </div>
                        </div>
                        <br><br><br>
                        

                             <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description <span class="required">*</span>
                          </label>
                          <div class="ccol-md-9 col-sm-9 col-xs-12">
                            <textarea placeholder="Product Description..." class="textarea form-control" rows="5"  name="productDescription" id="myTextarea" required></textarea><br>
                          </div>
                        </div>
                        <br><br><br>


                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Price <span class="required">*</span>
                          </label>
                          <div class="ccol-md-9 col-sm-9 col-xs-12">
                            <input type="text" name="productPrice"  value="<?php if (isset($_POST['productPrice']) && !$flag) echo $_POST['productPrice']; ?>" class="form-control col-md-9 col-sm-9 col-xs-12" required>
                          </div>
                        </div>
                        <br><br><br>

                        <br><br<br><br><br>
                        <div class="form-group">
                          
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" name="dropdown_category" required>
                              <option selected disabled>Select Category</option>
                              <option value="apparel">Apparel</option>
                              <option value="drinkware">Drinkware</option>
                              <option value="toys">Toys</option>
                              <option value="accessories">Accessroies</option>
                            </select>
                            <?php if (isset($_POST['dropdown_category']) && !$flag) echo $_POST['dropdown_category']; ?>
                            <br>

                          </div>
                        </div>
                        <br><br><br>

                          <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub-Category</label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" name="dropdown_Subcategory" required>
                              <option selected disabled>Select Sub-Category</option>
                              <option value="shirts">Shirts</option>
                              <option value="hoodies">Hoodies</option>
                              <option value="footware">FootWare</option>

                              <option value="mugs" >Mugs</option>
                              <option value="tumblers" >Tumblers</option>
                              <option value="shotglasses" >Shotglasses</option>

                              <option value="plushies">Plushies</option>
                              <option value="pillows">Pillows</option>

                              <option value="bracelets">Bracelets</option>
                              <option value="pendants">Pendants</option>
                              <option value="magnets">Magnets</option>
                              <option value="keychains">Keychains</option>
                            </select>
                              <?php if (isset($_POST['dropdown_Subcategory']) && !$flag) echo $_POST['dropdown_Subcategory']; ?>
                             <br>
                          </div>
                        </div>

                          <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Minimum Stock <span class="required">*</span>
                          </label>
                          <div class="ccol-md-9 col-sm-9 col-xs-12">
                            <input type="text" name="minStock" value="<?php if (isset($_POST['minStock']) && !$flag) echo $_POST['minStock']; ?>" class="form-control col-md-9 col-sm-9 col-xs-12" required>
                          </div>
                        </div>
                        <br><br><br><br><br>

                          <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Image: <span class="required">*</span>
                          </label>
                          <div class="ccol-md-9 col-sm-9 col-xs-12">
                             <input type="file" name="fileToUpload">
                          </div>
                        </div>
                        <br>
                        
                       

                        <br>
                            <div class="form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">Select Sizes
                          <br>
                        </label>
                      </div>

                        <div class="col-md-9 col-sm-9 col-xs-12">
                       
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="S" value="S" class="flat"> S
                              <br><br>
                               <input type="checkbox" name="M" value="M"class="flat"> M
                               <br><br>
                                <input type="checkbox" name="L" value="L"class="flat"> L
                                <br><br>
                                 <input type="checkbox"  name="noSize" value="noSize" class="flat"> No Size
                            </label>
                          </div>
                   
                      </div>
        
                        <br>

                        <div class="form-group">
                          <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <div align="center">
                            <input type="submit" name="submitProduct"  class="btn btn-success"value="Add Product!" />
                          </div>
                          </div>
                        </div>

                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

            


        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="js/moment/moment.min.js"></script>
    <script src="js/datepicker/daterangepicker.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="../vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="../vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="../vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="../vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="../vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="../vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="../vendors/starrr/dist/starrr.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

    <!-- bootstrap-daterangepicker -->
    <script>
      $(document).ready(function() {
        $('#birthday').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_4"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>
    <!-- /bootstrap-daterangepicker -->

    <!-- bootstrap-wysiwyg -->
    <script>
      $(document).ready(function() {
        function initToolbarBootstrapBindings() {
          var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
              'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
              'Times New Roman', 'Verdana'
            ],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
          $.each(fonts, function(idx, fontName) {
            fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
          });
          $('a[title]').tooltip({
            container: 'body'
          });
          $('.dropdown-menu input').click(function() {
              return false;
            })
            .change(function() {
              $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
            })
            .keydown('esc', function() {
              this.value = '';
              $(this).change();
            });

          $('[data-role=magic-overlay]').each(function() {
            var overlay = $(this),
              target = $(overlay.data('target'));
            overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
          });

          if ("onwebkitspeechchange" in document.createElement("input")) {
            var editorOffset = $('#editor').offset();

            $('.voiceBtn').css('position', 'absolute').offset({
              top: editorOffset.top,
              left: editorOffset.left + $('#editor').innerWidth() - 35
            });
          } else {
            $('.voiceBtn').hide();
          }
        }

        function showErrorAlert(reason, detail) {
          var msg = '';
          if (reason === 'unsupported-file-type') {
            msg = "Unsupported format " + detail;
          } else {
            console.log("error uploading file", reason, detail);
          }
          $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
            '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
        }

        initToolbarBootstrapBindings();

        $('#editor').wysiwyg({
          fileUploadError: showErrorAlert
        });

        window.prettyPrint;
        prettyPrint();
      });
    </script>
    <!-- /bootstrap-wysiwyg -->

    <!-- Select2 -->
    <script>
      $(document).ready(function() {
        $(".select2_single").select2({
          placeholder: "Select a state",
          allowClear: true
        });
        $(".select2_group").select2({});
        $(".select2_multiple").select2({
          maximumSelectionLength: 4,
          placeholder: "With Max Selection limit 4",
          allowClear: true
        });
      });
    </script>
    <!-- /Select2 -->

    <!-- jQuery Tags Input -->
    <script>
      function onAddTag(tag) {
        alert("Added a tag: " + tag);
      }

      function onRemoveTag(tag) {
        alert("Removed a tag: " + tag);
      }

      function onChangeTag(input, tag) {
        alert("Changed a tag: " + tag);
      }

      $(document).ready(function() {
        $('#tags_1').tagsInput({
          width: 'auto'
        });
      });
    </script>
    <!-- /jQuery Tags Input -->

    <!-- Parsley -->
    <script>
      $(document).ready(function() {
        $.listen('parsley:field:validate', function() {
          validateFront();
        });
        $('#demo-form .btn').on('click', function() {
          $('#demo-form').parsley().validate();
          validateFront();
        });
        var validateFront = function() {
          if (true === $('#demo-form').parsley().isValid()) {
            $('.bs-callout-info').removeClass('hidden');
            $('.bs-callout-warning').addClass('hidden');
          } else {
            $('.bs-callout-info').addClass('hidden');
            $('.bs-callout-warning').removeClass('hidden');
          }
        };
      });

      $(document).ready(function() {
        $.listen('parsley:field:validate', function() {
          validateFront();
        });
        $('#demo-form2 .btn').on('click', function() {
          $('#demo-form2').parsley().validate();
          validateFront();
        });
        var validateFront = function() {
          if (true === $('#demo-form2').parsley().isValid()) {
            $('.bs-callout-info').removeClass('hidden');
            $('.bs-callout-warning').addClass('hidden');
          } else {
            $('.bs-callout-info').addClass('hidden');
            $('.bs-callout-warning').removeClass('hidden');
          }
        };
      });
      try {
        hljs.initHighlightingOnLoad();
      } catch (err) {}
    </script>
    <!-- /Parsley -->

    <!-- Autosize -->
    <script>
      $(document).ready(function() {
        autosize($('.resizable_textarea'));
      });
    </script>
    <!-- /Autosize -->

    <!-- jQuery autocomplete -->
    <script>
      $(document).ready(function() {
        var countries = { AD:"Andorra",A2:"Andorra Test",AE:"United Arab Emirates",AF:"Afghanistan",AG:"Antigua and Barbuda",AI:"Anguilla",AL:"Albania",AM:"Armenia",AN:"Netherlands Antilles",AO:"Angola",AQ:"Antarctica",AR:"Argentina",AS:"American Samoa",AT:"Austria",AU:"Australia",AW:"Aruba",AX:"Åland Islands",AZ:"Azerbaijan",BA:"Bosnia and Herzegovina",BB:"Barbados",BD:"Bangladesh",BE:"Belgium",BF:"Burkina Faso",BG:"Bulgaria",BH:"Bahrain",BI:"Burundi",BJ:"Benin",BL:"Saint Barthélemy",BM:"Bermuda",BN:"Brunei",BO:"Bolivia",BQ:"British Antarctic Territory",BR:"Brazil",BS:"Bahamas",BT:"Bhutan",BV:"Bouvet Island",BW:"Botswana",BY:"Belarus",BZ:"Belize",CA:"Canada",CC:"Cocos [Keeling] Islands",CD:"Congo - Kinshasa",CF:"Central African Republic",CG:"Congo - Brazzaville",CH:"Switzerland",CI:"Côte d’Ivoire",CK:"Cook Islands",CL:"Chile",CM:"Cameroon",CN:"China",CO:"Colombia",CR:"Costa Rica",CS:"Serbia and Montenegro",CT:"Canton and Enderbury Islands",CU:"Cuba",CV:"Cape Verde",CX:"Christmas Island",CY:"Cyprus",CZ:"Czech Republic",DD:"East Germany",DE:"Germany",DJ:"Djibouti",DK:"Denmark",DM:"Dominica",DO:"Dominican Republic",DZ:"Algeria",EC:"Ecuador",EE:"Estonia",EG:"Egypt",EH:"Western Sahara",ER:"Eritrea",ES:"Spain",ET:"Ethiopia",FI:"Finland",FJ:"Fiji",FK:"Falkland Islands",FM:"Micronesia",FO:"Faroe Islands",FQ:"French Southern and Antarctic Territories",FR:"France",FX:"Metropolitan France",GA:"Gabon",GB:"United Kingdom",GD:"Grenada",GE:"Georgia",GF:"French Guiana",GG:"Guernsey",GH:"Ghana",GI:"Gibraltar",GL:"Greenland",GM:"Gambia",GN:"Guinea",GP:"Guadeloupe",GQ:"Equatorial Guinea",GR:"Greece",GS:"South Georgia and the South Sandwich Islands",GT:"Guatemala",GU:"Guam",GW:"Guinea-Bissau",GY:"Guyana",HK:"Hong Kong SAR China",HM:"Heard Island and McDonald Islands",HN:"Honduras",HR:"Croatia",HT:"Haiti",HU:"Hungary",ID:"Indonesia",IE:"Ireland",IL:"Israel",IM:"Isle of Man",IN:"India",IO:"British Indian Ocean Territory",IQ:"Iraq",IR:"Iran",IS:"Iceland",IT:"Italy",JE:"Jersey",JM:"Jamaica",JO:"Jordan",JP:"Japan",JT:"Johnston Island",KE:"Kenya",KG:"Kyrgyzstan",KH:"Cambodia",KI:"Kiribati",KM:"Comoros",KN:"Saint Kitts and Nevis",KP:"North Korea",KR:"South Korea",KW:"Kuwait",KY:"Cayman Islands",KZ:"Kazakhstan",LA:"Laos",LB:"Lebanon",LC:"Saint Lucia",LI:"Liechtenstein",LK:"Sri Lanka",LR:"Liberia",LS:"Lesotho",LT:"Lithuania",LU:"Luxembourg",LV:"Latvia",LY:"Libya",MA:"Morocco",MC:"Monaco",MD:"Moldova",ME:"Montenegro",MF:"Saint Martin",MG:"Madagascar",MH:"Marshall Islands",MI:"Midway Islands",MK:"Macedonia",ML:"Mali",MM:"Myanmar [Burma]",MN:"Mongolia",MO:"Macau SAR China",MP:"Northern Mariana Islands",MQ:"Martinique",MR:"Mauritania",MS:"Montserrat",MT:"Malta",MU:"Mauritius",MV:"Maldives",MW:"Malawi",MX:"Mexico",MY:"Malaysia",MZ:"Mozambique",NA:"Namibia",NC:"New Caledonia",NE:"Niger",NF:"Norfolk Island",NG:"Nigeria",NI:"Nicaragua",NL:"Netherlands",NO:"Norway",NP:"Nepal",NQ:"Dronning Maud Land",NR:"Nauru",NT:"Neutral Zone",NU:"Niue",NZ:"New Zealand",OM:"Oman",PA:"Panama",PC:"Pacific Islands Trust Territory",PE:"Peru",PF:"French Polynesia",PG:"Papua New Guinea",PH:"Philippines",PK:"Pakistan",PL:"Poland",PM:"Saint Pierre and Miquelon",PN:"Pitcairn Islands",PR:"Puerto Rico",PS:"Palestinian Territories",PT:"Portugal",PU:"U.S. Miscellaneous Pacific Islands",PW:"Palau",PY:"Paraguay",PZ:"Panama Canal Zone",QA:"Qatar",RE:"Réunion",RO:"Romania",RS:"Serbia",RU:"Russia",RW:"Rwanda",SA:"Saudi Arabia",SB:"Solomon Islands",SC:"Seychelles",SD:"Sudan",SE:"Sweden",SG:"Singapore",SH:"Saint Helena",SI:"Slovenia",SJ:"Svalbard and Jan Mayen",SK:"Slovakia",SL:"Sierra Leone",SM:"San Marino",SN:"Senegal",SO:"Somalia",SR:"Suriname",ST:"São Tomé and Príncipe",SU:"Union of Soviet Socialist Republics",SV:"El Salvador",SY:"Syria",SZ:"Swaziland",TC:"Turks and Caicos Islands",TD:"Chad",TF:"French Southern Territories",TG:"Togo",TH:"Thailand",TJ:"Tajikistan",TK:"Tokelau",TL:"Timor-Leste",TM:"Turkmenistan",TN:"Tunisia",TO:"Tonga",TR:"Turkey",TT:"Trinidad and Tobago",TV:"Tuvalu",TW:"Taiwan",TZ:"Tanzania",UA:"Ukraine",UG:"Uganda",UM:"U.S. Minor Outlying Islands",US:"United States",UY:"Uruguay",UZ:"Uzbekistan",VA:"Vatican City",VC:"Saint Vincent and the Grenadines",VD:"North Vietnam",VE:"Venezuela",VG:"British Virgin Islands",VI:"U.S. Virgin Islands",VN:"Vietnam",VU:"Vanuatu",WF:"Wallis and Futuna",WK:"Wake Island",WS:"Samoa",YD:"People's Democratic Republic of Yemen",YE:"Yemen",YT:"Mayotte",ZA:"South Africa",ZM:"Zambia",ZW:"Zimbabwe",ZZ:"Unknown or Invalid Region" };

        var countriesArray = $.map(countries, function(value, key) {
          return {
            value: value,
            data: key
          };
        });

        // initialize autocomplete with custom appendTo
        $('#autocomplete-custom-append').autocomplete({
          lookup: countriesArray,
          appendTo: '#autocomplete-container'
        });
      });
    </script>
    <!-- /jQuery autocomplete -->

    <!-- Starrr -->
    <script>
      $(document).ready(function() {
        $(".stars").starrr();

        $('.stars-existing').starrr({
          rating: 4
        });

        $('.stars').on('starrr:change', function (e, value) {
          $('.stars-count').html(value);
        });

        $('.stars-existing').on('starrr:change', function (e, value) {
          $('.stars-count-existing').html(value);
        });
      });
    </script>
    <!-- /Starrr -->
  </body>
</html>
