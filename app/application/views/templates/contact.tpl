{extends file='layouts/layout.tpl'}

{block name="css"}
    <link rel="stylesheet" href="{$MEDIA_FILES_URL}css/contact.css">
{/block}

{block name="content"}

<!-- Search Result Headding -->

<div class="viewAllArticle bg-light-gray" ng-model="type_id">
    <div class="container">
        <div class="col-xs-7 no-padding">
            <div class="font-family-light text-26 margin-vertical-10"><div class="arrow_box"></div>{$response.pageTitle|upper}</div>
        </div>
        <div class="col-xs-5 no-padding">
            <ol class="breadcrumb">
              <li><a href="{$APP_BASE_URL}" class="text-dark-gray">Home</a></li>
              <li class="active">Contact Us</li>
            </ol>
        </div>
    </div>
</div>

<!-- Filter of search result -->

<div class="container bg-white">
    <div class="mapDiv margin-vertical-per-6">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1944.3034542661617!2d77.6142604576723!3d12.932967585831785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae1451ed7dbb8d%3A0x6f03cd8878699fb6!2sZinnov+Management+Consulting+Private+Limited!5e0!3m2!1sen!2sin!4v1435818317150" width="100%" height="270" frameborder="0" style="border:0" allowfullscreen=""></iframe>
    </div>   
    <div class="col-xs-12 no-padding">        
        <div class="col-xs-12 col-sm-7 no-padding">
            <h4 class="margin-vertical-per-6"> SEND ENQUIRY </h4>
            <form action="{$APP_BASE_URL}contact" method="post" enctype="multipart/form-data" onsubmit="return ValidateInquiry();">
                <div class="row margin-vertical-10">
                    <div class="col-xs-4 col-sm-3 no-padding">
                        <label class="text-gray">Name <span class="text-red">*</span></label>
                    </div>
                    <div class="col-xs-8 col-sm-9 no-padding">
                        <input type="text" maxlength="100" class="form-control" id="name" name="name"/>
                    </div>
                </div>
                <div class="row margin-vertical-10">
                    <div class="col-xs-4 col-sm-3 no-padding">
                        <label class="text-gray">Email <span class="text-red">*</span></label>
                    </div>
                    <div class="col-xs-8 col-sm-9 no-padding">
                        <input type="text" maxlength="100" class="form-control" id="email" name="email"/>
                    </div>
                </div>
                <div class="row margin-vertical-10">
                    <div class="col-xs-4 col-sm-3 no-padding">
                        <label class="text-gray">Website </label>
                    </div>
                    <div class="col-xs-8 col-sm-9 no-padding">
                        <input type="text" maxlength="100" class="form-control" id="website" name="website" />
                    </div>
                </div>
                <div class="row margin-vertical-10">
                    <div class="col-xs-4 col-sm-3 no-padding">
                        <label class="text-gray">Message <span class="text-red">*</span></label>
                    </div>
                    <div class="col-xs-8 col-sm-9 no-padding">
                        <textarea class="form-control" maxlength="250" rows="6" id="message" name="message"></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
                <button type="submit" class="btn btn-box-orange padding-top-6 padding-bottom-6 padding-left-52 padding-right-52">SEND</button>
            </form>
        </div>
        <div class="col-xs-12 col-sm-4 col-sm-offset-1 no-right-padding">
            <h4 class="margin-vertical-per-11"> ADDRESS </h4>
            <address>
                <div><i class="fa fa-map-marker text-orange pull-left"></i><div class="padding-horizontal-21">Bangalore Office: 69 “Prathiba Complex”, 4th ‘A’ Cross Koramangala Ind. Layout, Koramangala 5th Block, Bangalore-560 095.</div></div><br />
                <p><i class="fa fa-phone"></i><span class="padding-horizontal-5">080 4112 7925</span></p>
                <p><i class="fa fa-envelope-o"></i><span class="padding-horizontal-5"><a href="mailto:R2i@zinnov.com" target="_top" class="text-orange">media@zinnov.com.</a></span></p>
            </address>
        </div>
    </div>
</div>
{/block}
