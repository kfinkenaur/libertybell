  <br />  
  <table  cellpadding="0" cellspacing="0" style="margin:0px;border:0px;width:100%;">
   <tr style="border:0px;">
    <td style="padding:0px;border:0px;">
      <div class="fields" id="field-c0-ppp">
         <label>First Name:</label>
         <div class="dfield">
           <input type="text" size="15" name="cfpp_customer_first_name" id="cfpp_customer_first_name" value="" />
         </div>
         <div class="clearer"></div>
      </div><div class="dfield">
   </td>
    <td style="border:0px;">
      <div class="fields" id="field-c0-ppp">
         <label>Last Name:</label>
         <div class="dfield">
           <input type="text" size="15" name="cfpp_customer_last_name" id="cfpp_customer_last_name" value="" />
         </div>
         <div class="clearer"></div>
      </div>        
     </td>
   </tr>
  </table> 
  <table  cellpadding="0" cellspacing="0" style="margin:0px;border:0px;width:100%;">
   <tr>
    <td style="padding:0px; border:0px;" nowrap>
      <div class="fields" id="field-c0-ppp">
         <label>Credit Card Number:</label>
         <div class="dfield">
           <input type="text" size="18" name="cfpp_customer_credit_card_number" id="cfpp_customer_credit_card_number" value="" />
         </div>
         <div class="clearer"></div>
      </div>        
    </td>
    <td style="border:0px;" nowrap>
      <div class="fields" id="field-c0-ppp">
         <label>CVV Number:</label>
         <div class="dfield">
           <input type="text" size="5" name="cfpp_cc_cvv2_number" id="cfpp_cc_cvv2_number" value="" />
         </div>
         <div class="clearer"></div>
      </div>        
    </td>
   </tr>
  </table>   
  <table  cellpadding="0" cellspacing="0" style="margin:0px;border:0px;width:100%;">
   <tr>
    <td style="padding:0px;border:0px;" nowrap>
      <div class="fields" id="field-c0-ppp">
         <label>Card Type:</label>
         <div class="dfield">
           <select name="cfpp_customer_credit_card_type" id="cfpp_customer_credit_card_type"><option value="Visa" vt="Visa">Visa</option><option value="MasterCard" vt="MasterCard">>MasterCard</option><option value="Discover" vt="Discover">Discover</option><option value="Amex" vt="Amex">Amex</option></select>
         </div>
         <div class="clearer"></div>
      </div>    
    </td>
    <td style="border:0px;" nowrap>
      <div class="fields" id="field-c0-ppp">
         <label>Expiration:</label>
         <div class="dfield">
           <select name="cfpp_cc_expiration_month">                
           <option value="01" vt="01">January</option>
           <option value="02" vt="02">February</option>
           <option value="03" vt="03">March</option>
           <option value="04" vt="04">April</option>
           <option value="05" vt="05">May</option>
           <option value="06" vt="06">June</option>
           <option value="07" vt="07">July</option>
           <option value="08" vt="08">August</option>
           <option value="09" vt="09">September</option>
           <option value="10" vt="10">October</option>
           <option value="11" vt="11">November</option>
           <option value="12" vt="12">December</option>
          </select> /
          <select name="cfpp_cc_expiration_year">   
          <?php $d= intval(date("Y")); for($i=$d;$i<$d+10;$i++) echo '<option value="'.$i.'" vt="'.$i.'">'.$i.'</option>'; ?>
          </select>         
         </div>
         <div class="clearer"></div>
      </div>        
   </td>
  </tr>
 </table>
  <table cellpadding="0" cellspacing="0" style="margin:0px;border:0px;width:100%;">
   <tr>
    <td style="padding:0px;border:0px;" colspan="3" nowrap>Address:<br /><div class="dfield"><input type="text" size="30" name="cfpp_customer_address1" id="cfpp_customer_address1" value="" /><br /><input type="text" size="30" name="cfpp_customer_address2" id="cfpp_customer_address2" value="" /></div></td>   
   </tr>
   <tr>
    <td style="padding:0px;border:0px;" nowrap>
      <div class="fields" id="field-c0-ppp">
         <label>City:</label>
         <div class="dfield">
           <input type="text" size="15" name="cfpp_customer_city" id="cfpp_customer_city" value="" />
         </div>
         <div class="clearer"></div>
      </div>            
    </td>
    <td style="border:0px;" nowrap>
      <div class="fields" id="field-c0-ppp">
         <label>County:</label>
         <div class="dfield">
           <input type="text" size="15" name="cfpp_customer_state" id="cfpp_customer_state" value="" />
         </div>
         <div class="clearer"></div>
      </div>         
    </td>
    <td style="border:0px;" nowrap>
      <div class="fields" id="field-c0-ppp">
         <label>Post Code:</label>
         <div class="dfield">
           <input type="text" size="5" name="cfpp_customer_zip" id="cfpp_customer_zip" value="" />
         </div>
         <div class="clearer"></div>
      </div>           
    </td>
   </tr> 
   <tr>
    <td style="padding:0px;border:0px;" colspan="3" nowrap>
        
      <div class="fields" id="field-c0-ppp">
         <label>Country:</label>
         <div class="dfield">
<select name="cfpp_customer_country" id="cfpp_customer_country">
	<option value="AF">Afghanistan</option>
	<option value="AX">Åland Islands</option>
	<option value="AL">Albania</option>
	<option value="DZ">Algeria</option>
	<option value="AS">American Samoa</option>
	<option value="AD">Andorra</option>
	<option value="AO">Angola</option>
	<option value="AI">Anguilla</option>
	<option value="AQ">Antarctica</option>
	<option value="AG">Antigua and Barbuda</option>
	<option value="AR">Argentina</option>
	<option value="AM">Armenia</option>
	<option value="AW">Aruba</option>
	<option value="AU">Australia</option>
	<option value="AT">Austria</option>
	<option value="AZ">Azerbaijan</option>
	<option value="BS">Bahamas</option>
	<option value="BH">Bahrain</option>
	<option value="BD">Bangladesh</option>
	<option value="BB">Barbados</option>
	<option value="BY">Belarus</option>
	<option value="BE">Belgium</option>
	<option value="BZ">Belize</option>
	<option value="BJ">Benin</option>
	<option value="BM">Bermuda</option>
	<option value="BT">Bhutan</option>
	<option value="BO">Bolivia, Plurinational State of</option>
	<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
	<option value="BA">Bosnia and Herzegovina</option>
	<option value="BW">Botswana</option>
	<option value="BV">Bouvet Island</option>
	<option value="BR">Brazil</option>
	<option value="IO">British Indian Ocean Territory</option>
	<option value="BN">Brunei Darussalam</option>
	<option value="BG">Bulgaria</option>
	<option value="BF">Burkina Faso</option>
	<option value="BI">Burundi</option>
	<option value="KH">Cambodia</option>
	<option value="CM">Cameroon</option>
	<option value="CA">Canada</option>
	<option value="CV">Cape Verde</option>
	<option value="KY">Cayman Islands</option>
	<option value="CF">Central African Republic</option>
	<option value="TD">Chad</option>
	<option value="CL">Chile</option>
	<option value="CN">China</option>
	<option value="CX">Christmas Island</option>
	<option value="CC">Cocos (Keeling) Islands</option>
	<option value="CO">Colombia</option>
	<option value="KM">Comoros</option>
	<option value="CG">Congo</option>
	<option value="CD">Congo, the Democratic Republic of the</option>
	<option value="CK">Cook Islands</option>
	<option value="CR">Costa Rica</option>
	<option value="CI">Côte d'Ivoire</option>
	<option value="HR">Croatia</option>
	<option value="CU">Cuba</option>
	<option value="CW">Curaçao</option>
	<option value="CY">Cyprus</option>
	<option value="CZ">Czech Republic</option>
	<option value="DK">Denmark</option>
	<option value="DJ">Djibouti</option>
	<option value="DM">Dominica</option>
	<option value="DO">Dominican Republic</option>
	<option value="EC">Ecuador</option>
	<option value="EG">Egypt</option>
	<option value="SV">El Salvador</option>
	<option value="GQ">Equatorial Guinea</option>
	<option value="ER">Eritrea</option>
	<option value="EE">Estonia</option>
	<option value="ET">Ethiopia</option>
	<option value="FK">Falkland Islands (Malvinas)</option>
	<option value="FO">Faroe Islands</option>
	<option value="FJ">Fiji</option>
	<option value="FI">Finland</option>
	<option value="FR">France</option>
	<option value="GF">French Guiana</option>
	<option value="PF">French Polynesia</option>
	<option value="TF">French Southern Territories</option>
	<option value="GA">Gabon</option>
	<option value="GM">Gambia</option>
	<option value="GE">Georgia</option>
	<option value="DE">Germany</option>
	<option value="GH">Ghana</option>
	<option value="GI">Gibraltar</option>
	<option value="GR">Greece</option>
	<option value="GL">Greenland</option>
	<option value="GD">Grenada</option>
	<option value="GP">Guadeloupe</option>
	<option value="GU">Guam</option>
	<option value="GT">Guatemala</option>
	<option value="GG">Guernsey</option>
	<option value="GN">Guinea</option>
	<option value="GW">Guinea-Bissau</option>
	<option value="GY">Guyana</option>
	<option value="HT">Haiti</option>
	<option value="HM">Heard Island and McDonald Islands</option>
	<option value="VA">Holy See (Vatican City State)</option>
	<option value="HN">Honduras</option>
	<option value="HK">Hong Kong</option>
	<option value="HU">Hungary</option>
	<option value="IS">Iceland</option>
	<option value="IN">India</option>
	<option value="ID">Indonesia</option>
	<option value="IR">Iran, Islamic Republic of</option>
	<option value="IQ">Iraq</option>
	<option value="IE">Ireland</option>
	<option value="IM">Isle of Man</option>
	<option value="IL">Israel</option>
	<option value="IT">Italy</option>
	<option value="JM">Jamaica</option>
	<option value="JP">Japan</option>
	<option value="JE">Jersey</option>
	<option value="JO">Jordan</option>
	<option value="KZ">Kazakhstan</option>
	<option value="KE">Kenya</option>
	<option value="KI">Kiribati</option>
	<option value="KP">Korea, Democratic People's Republic of</option>
	<option value="KR">Korea, Republic of</option>
	<option value="KW">Kuwait</option>
	<option value="KG">Kyrgyzstan</option>
	<option value="LA">Lao People's Democratic Republic</option>
	<option value="LV">Latvia</option>
	<option value="LB">Lebanon</option>
	<option value="LS">Lesotho</option>
	<option value="LR">Liberia</option>
	<option value="LY">Libya</option>
	<option value="LI">Liechtenstein</option>
	<option value="LT">Lithuania</option>
	<option value="LU">Luxembourg</option>
	<option value="MO">Macao</option>
	<option value="MK">Macedonia, the former Yugoslav Republic of</option>
	<option value="MG">Madagascar</option>
	<option value="MW">Malawi</option>
	<option value="MY">Malaysia</option>
	<option value="MV">Maldives</option>
	<option value="ML">Mali</option>
	<option value="MT">Malta</option>
	<option value="MH">Marshall Islands</option>
	<option value="MQ">Martinique</option>
	<option value="MR">Mauritania</option>
	<option value="MU">Mauritius</option>
	<option value="YT">Mayotte</option>
	<option value="MX">Mexico</option>
	<option value="FM">Micronesia, Federated States of</option>
	<option value="MD">Moldova, Republic of</option>
	<option value="MC">Monaco</option>
	<option value="MN">Mongolia</option>
	<option value="ME">Montenegro</option>
	<option value="MS">Montserrat</option>
	<option value="MA">Morocco</option>
	<option value="MZ">Mozambique</option>
	<option value="MM">Myanmar</option>
	<option value="NA">Namibia</option>
	<option value="NR">Nauru</option>
	<option value="NP">Nepal</option>
	<option value="NL">Netherlands</option>
	<option value="NC">New Caledonia</option>
	<option value="NZ">New Zealand</option>
	<option value="NI">Nicaragua</option>
	<option value="NE">Niger</option>
	<option value="NG">Nigeria</option>
	<option value="NU">Niue</option>
	<option value="NF">Norfolk Island</option>
	<option value="MP">Northern Mariana Islands</option>
	<option value="NO">Norway</option>
	<option value="OM">Oman</option>
	<option value="PK">Pakistan</option>
	<option value="PW">Palau</option>
	<option value="PS">Palestinian Territory, Occupied</option>
	<option value="PA">Panama</option>
	<option value="PG">Papua New Guinea</option>
	<option value="PY">Paraguay</option>
	<option value="PE">Peru</option>
	<option value="PH">Philippines</option>
	<option value="PN">Pitcairn</option>
	<option value="PL">Poland</option>
	<option value="PT">Portugal</option>
	<option value="PR">Puerto Rico</option>
	<option value="QA">Qatar</option>
	<option value="RE">Réunion</option>
	<option value="RO">Romania</option>
	<option value="RU">Russian Federation</option>
	<option value="RW">Rwanda</option>
	<option value="BL">Saint Barthélemy</option>
	<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
	<option value="KN">Saint Kitts and Nevis</option>
	<option value="LC">Saint Lucia</option>
	<option value="MF">Saint Martin (French part)</option>
	<option value="PM">Saint Pierre and Miquelon</option>
	<option value="VC">Saint Vincent and the Grenadines</option>
	<option value="WS">Samoa</option>
	<option value="SM">San Marino</option>
	<option value="ST">Sao Tome and Principe</option>
	<option value="SA">Saudi Arabia</option>
	<option value="SN">Senegal</option>
	<option value="RS">Serbia</option>
	<option value="SC">Seychelles</option>
	<option value="SL">Sierra Leone</option>
	<option value="SG">Singapore</option>
	<option value="SX">Sint Maarten (Dutch part)</option>
	<option value="SK">Slovakia</option>
	<option value="SI">Slovenia</option>
	<option value="SB">Solomon Islands</option>
	<option value="SO">Somalia</option>
	<option value="ZA">South Africa</option>
	<option value="GS">South Georgia and the South Sandwich Islands</option>
	<option value="SS">South Sudan</option>
	<option value="ES">Spain</option>
	<option value="LK">Sri Lanka</option>
	<option value="SD">Sudan</option>
	<option value="SR">Suriname</option>
	<option value="SJ">Svalbard and Jan Mayen</option>
	<option value="SZ">Swaziland</option>
	<option value="SE">Sweden</option>
	<option value="CH">Switzerland</option>
	<option value="SY">Syrian Arab Republic</option>
	<option value="TW">Taiwan, Province of China</option>
	<option value="TJ">Tajikistan</option>
	<option value="TZ">Tanzania, United Republic of</option>
	<option value="TH">Thailand</option>
	<option value="TL">Timor-Leste</option>
	<option value="TG">Togo</option>
	<option value="TK">Tokelau</option>
	<option value="TO">Tonga</option>
	<option value="TT">Trinidad and Tobago</option>
	<option value="TN">Tunisia</option>
	<option value="TR">Turkey</option>
	<option value="TM">Turkmenistan</option>
	<option value="TC">Turks and Caicos Islands</option>
	<option value="TV">Tuvalu</option>
	<option value="UG">Uganda</option>
	<option value="UA">Ukraine</option>
	<option value="AE">United Arab Emirates</option>
	<option value="GB">United Kingdom</option>
	<option value="US" selected>United States</option>
	<option value="UM">United States Minor Outlying Islands</option>
	<option value="UY">Uruguay</option>
	<option value="UZ">Uzbekistan</option>
	<option value="VU">Vanuatu</option>
	<option value="VE">Venezuela, Bolivarian Republic of</option>
	<option value="VN">Viet Nam</option>
	<option value="VG">Virgin Islands, British</option>
	<option value="VI">Virgin Islands, U.S.</option>
	<option value="WF">Wallis and Futuna</option>
	<option value="EH">Western Sahara</option>
	<option value="YE">Yemen</option>
	<option value="ZM">Zambia</option>
	<option value="ZW">Zimbabwe</option>
</select>
         </div>
         <div class="clearer"></div>
      </div>
    </td>   
   </tr>
  </table>