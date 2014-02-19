<div class="page-header">
    <h3>Settings</h3>
</div>

<form class="form-horizontal" role="form" method="post" autocomplete="off" parsley-validate novalidate>

    <h3 class="page-header"><small>Site settings</small></h3>
    
    <div class="form-group">
        <div class="col-md-3">
            <label for="data[name]">Site name</label>
            <small class="help-block">Site name that will be used in backend and can be used in themes as title.</small>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="data[name]" value="">
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-3">
            <label for="data[language]">Language</label>
            <small class="help-block">System language.</small>
        </div>
        <div class="col-md-3">
            <select class="form-control" name="data[language]">
                <option>English</option>
                <option>Russian</option>
            </select>
        </div>
    </div>  
    
    
    <div class="form-group">
        <div class="col-md-3">
            <label for="data[timezone]">Timezone</label>
            <small class="help-block">Site region standard time.</small>
        </div>
        <div class="col-md-3">
            <select class="form-control" name="data[timezone]">
                <option value="Pacific/Auckland">(GMT +13:00) International Date Line West</option>
                <option value="Pacific/Midway">(GMT -11:00) Midway Island, Samoa</option>
                <option value="US/Hawaii">(GMT -10:00) Hawaii</option>
                <option value="US/Alaska">(GMT -9:00) Alaska</option>
                <option value="US/Pacific">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
                <option value="America/Tijuana">(GMT -8:00) Tijuana, Baja California</option>
                <option value="America/Phoenix">(GMT -7:00) Arizona</option>
                <option value="America/Chihuahua">(GMT -7:00) Chihuahua, La Paz, Mazatlan</option>
                <option value="US/Mountain">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
                <option value="America/Cancun">(GMT -6:00) Central America</option>
                <option value="US/Central">(GMT -6:00) Central Time (US &amp; Canada)</option>
                <option value="America/Mexico_City">(GMT -6:00) Guadalajara, Mexico City, Monterrey</option>
                <option value="Canada/Saskatchewan">(GMT -6:00) Saskatchewan</option>
                <option value="America/Lima">(GMT -5:00) Bogota, Lima, Quito, Rio Branco</option>
                <option value="US/Eastern">(GMT -5:00) Eastern Time (US &amp; Canada)</option>
                <option value="US/East-Indiana">(GMT -5:00) Indiana (East)</option>
                <option value="Canada/Atlantic">(GMT -4:00) Atlantic Time (Canada)</option>
                <option value="America/Caracas">(GMT -5:30) Caracas, La Paz</option>
                <option value="America/Manaus">(GMT -4:00) Manaus</option>
                <option value="America/Santiago">(GMT -3:00) Santiago</option>
                <option value="Canada/Newfoundland">(GMT -4:30) Newfoundland</option>
                <option value="America/Sao_Paulo">(GMT -2:00) Brasilia</option>
                <option value="America/Argentina/Buenos_Aires">(GMT -3:00) Buenos Aires, Georgetown</option>
                <option value="America/Godthab">(GMT -3:00) Greenland</option>
                <option value="America/Montevideo">(GMT -2:00) Montevideo</option>
                <option value="Atlantic/South_Georgia">(GMT -2:00) Mid-Atlantic</option>
                <option value="Atlantic/Cape_Verde">(GMT -1:00) Cape Verde Is.</option>
                <option value="Atlantic/Azores">(GMT -1:00) Azores</option>
                <option value="Africa/Casablanca">(GMT +0:00) Casablanca, Monrovia, Reykjavik</option>
                <option value="UTC">(GMT +0:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
                <option value="Europe/Amsterdam">(GMT +1:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                <option value="Europe/Belgrade">(GMT +1:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                <option value="Europe/Brussels">(GMT +1:00) Brussels, Copenhagen, Madrid, Paris</option>
                <option value="Europe/Sarajevo">(GMT +1:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
                <option value="Africa/Windhoek">(GMT +2:00) West Central Africa</option>
                <option value="Asia/Amman">(GMT +2:00) Amman</option>
                <option value="Europe/Athens">(GMT +2:00) Athens, Bucharest, Istanbul</option>
                <option value="Asia/Beirut">(GMT +2:00) Beirut</option>
                <option value="Africa/Cairo">(GMT +2:00) Cairo</option>
                <option value="Africa/Harare">(GMT +2:00) Harare, Pretoria</option>
                <option value="Europe/Helsinki" selected>(GMT +2:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
                <option value="Asia/Jerusalem">(GMT +2:00) Jerusalem</option>
                <option value="Europe/Minsk">(GMT +3:00) Minsk</option>
                <option value="Africa/Windhoek">(GMT +2:00) Windhoek</option>
                <option value="Asia/Kuwait">(GMT +3:00) Kuwait, Riyadh, Baghdad</option>
                <option value="Europe/Moscow">(GMT +4:00) Moscow, St. Petersburg, Volgograd</option>
                <option value="Africa/Nairobi">(GMT +3:00) Nairobi</option>
                <option value="Asia/Tbilisi">(GMT +4:00) Tbilisi</option>
                <option value="Asia/Tehran">(GMT +3:30) Tehran</option>
                <option value="Asia/Muscat">(GMT +4:00) Abu Dhabi, Muscat</option>
                <option value="Asia/Baku">(GMT +4:00) Baku</option>
                <option value="Asia/Yerevan">(GMT +4:00) Yerevan</option>
                <option value="Asia/Kabul">(GMT +4:30) Kabul</option>
                <option value="Asia/Yekaterinburg">(GMT +6:00) Yekaterinburg</option>
                <option value="Asia/Karachi">(GMT +5:00) Islamabad, Karachi, Tashkent</option>
                <option value="Asia/Kolkata">(GMT +5:30) Sri Jayawardenepura</option>
                <option value="Asia/Kolkata">(GMT +5:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                <option value="Asia/Kathmandu">(GMT +5:45) Kathmandu</option>
                <option value="Asia/Almaty">(GMT +6:00) Almaty, Novosibirsk</option>
                <option value="Asia/Dhaka">(GMT +6:00) Astana, Dhaka</option>
                <option value="Asia/Rangoon">(GMT +6:30) Yangon (Rangoon)</option>
                <option value="Asia/Bangkok">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
                <option value="Asia/Krasnoyarsk">(GMT +8:00) Krasnoyarsk</option>
                <option value="Asia/Shanghai">(GMT +8:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                <option value="Asia/Singapore">(GMT +8:00) Kuala Lumpur, Singapore</option>
                <option value="Asia/Irkutsk">(GMT +9:00) Irkutsk, Ulaan Bataar</option>
                <option value="Australia/Perth">(GMT +8:00) Perth</option>
                <option value="Asia/Taipei">(GMT +8:00) Taipei</option>
                <option value="Asia/Tokyo">(GMT +9:00) Osaka, Sapporo, Tokyo</option>
                <option value="Asia/Seoul">(GMT +9:00) Seoul</option>
                <option value="Asia/Yakutsk">(GMT +10:00) Yakutsk</option>
                <option value="Australia/Adelaide">(GMT +10:30) Adelaide</option>
                <option value="Australia/Darwin">(GMT +9:30) Darwin</option>
                <option value="Australia/Brisbane">(GMT +10:00) Brisbane</option>
                <option value="Australia/Sydney">(GMT +11:00) Canberra, Melbourne, Sydney</option>
                <option value="Australia/Hobart">(GMT +11:00) Hobart</option>
                <option value="Pacific/Guam">(GMT +10:00) Guam, Port Moresby</option>
                <option value="Asia/Vladivostok">(GMT +11:00) Vladivostok</option>
                <option value="Asia/Magadan">(GMT +12:00) Magadan, Solomon Is., New Caledonia</option>
                <option value="Pacific/Auckland">(GMT +13:00) Auckland, Wellington</option>
                <option value="Pacific/Fiji">(GMT +12:00) Fiji, Kamchatka, Marshall Is.</option>
                <option value="Pacific/Tongatapu">(GMT +13:00) Nuku'alofa</option>
            </select>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-3">
            <label for="data[mode]">Development mode</label>
            <small class="help-block">Disable caching, and show PHP errors.</small>
        </div>
        <div class="col-md-3">
        <label class="checkbox-switcher">
            <input type="checkbox" name="data[mode]" checked>
            <span class="switch">
                <span class="btn btn-danger btn-xs">On</span>
                <span class="btn btn-default btn-xs">Off</span>	   
                <span></span>
            </span>
        </label>
        </div>
    </div>

    <h3 class="page-header"><small>Pages settings</small></h3>
    
    <div class="form-group">
        <div class="col-md-3">
            <label for="data[theme]">Default theme</label>
            <small class="help-block">Default theme that will be used in frontend.</small>
        </div>
        <div class="col-md-3">
            <select class="form-control" name="data[theme]">
                <option>Default</option>
                <option>SomeTheme</option>
            </select>
        </div>
    </div>  
    
    <div class="form-group">
        <div class="col-md-3">
            <label for="data[status]">Page status</label>
            <small class="help-block">Default status for page for created pages.</small>
        </div>
        <div class="col-md-3">
            <div class="radio">
                <label>
                    <input type="radio" name="data[status]" value="1" checked>
                    <p>Published</p>
                </label>
                <label>
                    <input type="radio" name="data[status]" value="0"> 
                    <p>Unpublished</p>
                </label>
            </div>
        </div>
    </div> 
    
    <div class="form-group">
        <div class="col-md-3">
            <input type="submit" class="btn btn-primary" value="Save" /> or <a href="<?php echo $this->controller->createUrl(array('index')); ?>">Cancel</a>
        </div>
    </div>
</form>

	