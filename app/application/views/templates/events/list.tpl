{extends file='layouts/layout.tpl'}


{block name="css"}
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/event.css">
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/owl.carousel.css">
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/owl.theme.css">
{/block}

{block name="content"}

{assign pag_url strstr(uri_string(), 'page/', true) }
{if strlen(trim($pag_url)) <= 0}{assign pag_url uri_string()|cat:"/"}{/if}

<!-- Forum Headding -->

<input type="hidden" id="currentShowType"  name="currentShowType" value="{if isset($response.currentShowType)}{$response.currentShowType}{/if}" />
<div class="eventHeader bg-light-gray" ng-model="type_id">
    <div class="container">
		<div class="col-xs-7 no-padding">
            <div class="font-family-light text-26 margin-vertical-10"><div class="arrow_box"></div>{$response.pageTitle|upper} </div>
        </div>
        <div class="col-xs-5 no-padding">
            <ol class="breadcrumb">
              <li><a href="{$APP_BASE_URL}" class="text-dark-gray">Home</a></li>
              <li class="active">Events</li>
            </ol>
        </div>
    </div>
</div>

<div class="banner container-fluid no-padding">
    <div id="homePageBanner" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <!-- <ol class="carousel-indicators">
        <li data-target="#homePageBanner" data-slide-to="0" class="active"></li>
      </ol> -->
      <div class="carousel-inner" role="listbox">
        <div class="item active" id="itemEvent1">
          <img class="hidden-xs first-slide width_100" src="{$MEDIA_FILES_URL}images/Banner.jpg" alt="First slide">
          <div class="container">
            <div class="banner-caption">
              <div class="container bg-light-gray radius-3">
                <div class="pull-left">
                    <h3>Up Coming Event</h3>
                    <p class="text-small"> 
                        {$current_date = gmdate("Y-m-d H:i:s")}
                        {if isset($response.events)}
                        {assign isDisplayed 0}
                        {foreach from=$response.events item=events}       
                            {if ($isDisplayed == 0) && (strtotime($events->server_time) > strtotime($current_date) ) && $events->status != 0 && $events->privacy != 0}
                                {$events->name}
                                {assign ticketId $events->perma_link}
                                {assign isDisplayed 1}                          
                            {/if}
                        {/foreach}
                        {/if}
                    </p>
                </div>
				{if isset($response.events) && isset($ticketId)}
					<a class="btn btn-box-orange registrationButton pull-right" href="https://www.eventbrite.com/e/testing-tickets-{$ticketId}?ref=ecount" target="_new" role="button">Register Now</a></div>      
				{/if}	
		    </div>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Related Catogery -->
{assign upcomingEventCount 0} 
<div id="upcomingEvents" class="no-display">
    <div class="container-fluid bg-light-gray margin-bottom-20 eventcontainer">
        <h2 class="center"> UPCOMING </h2>  
    </div>

    <div class="container eventwrap"> 
    	<div class="col-xs-12 no-padding">
    		{$current_date = gmdate("Y-m-d H:i:s")}
    		{if isset($response.events)}
			<!--<pre>
				{print_r($response)}
			</pre>-->
            <div id="owl-events" class="owl-carousel margin-bottom-20">
                {foreach $response.events as $key => $events}				
    				{if (strtotime($events->server_time) > strtotime($current_date) ) && $events->status != 0 && $events->privacy != 0}	
                    {assign var="upcomingEventCount" value=$upcomingEventCount+1}			
                    <div ng-cloak>
                        <div class="col-xs-12 singleArticle no-padding margin-bottom-10">                  
                            <div class="col-xs-12 no-padding articleContent center">
                                <a href="{$APP_BASE_URL}event/{$events->perma_link|lower}">
									{if isset($events->thumbnail_image)}
										<img src="{$APP_BASE_URL}image/events?file_name={$events->id}/{$events->thumbnail_image}" alt="" class="width_90 center-margin radius-5"/>
									{else}
										<img src="{$MEDIA_FILES_URL}uploads/images/events/img_events.jpg" alt="" class="width_90 center-margin radius-5"/>
									{/if}
							    <button class="btn btn-box-grey col-xs-4 readmoreEvent">Read More</button></a>
                                <div class="showOnHoverEventContent">
                                    <a href="{$APP_BASE_URL}event/{$events->perma_link|lower}">
                                        <p class="text-white text-medium margin-top-20 padding-5"><i class="text-white">{$events->name}</i></p>
                                         <div class="col-md-12 articleFooter no-padding">
                                            <div class="socicalIcon">
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={$APP_BASE_URL}event/{$events->perma_link|lower}" target="_blank">
                                                    <img class="margin-3" src="{$MEDIA_FILES_URL}images/facebook (2).png">
                                                </a>
                                                <a href="https://plus.google.com/share?url={$APP_BASE_URL}event/{$events->perma_link|lower}" target="_blank">
                                                    <img class="margin-3" src="{$MEDIA_FILES_URL}images/g+.png"></a>
                                                <a href="https://twitter.com/home?status={$APP_BASE_URL}event/{$events->perma_link|lower}" target="_blank">
                                                    <img class="margin-3" src="{$MEDIA_FILES_URL}images/twitter (2).png"></a>
                                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={$APP_BASE_URL}event/{$events->perma_link|lower}" target="_blank">
                                                    <img class="margin-3" src="{$MEDIA_FILES_URL}images/in.png"></a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>              
                    </div>
    				{/if}
                {/foreach}
            </div>                          
            {else}
                <h3 class="no-top-margin">No Events Found!</h3>
            {/if}		
    	</div>    	
    </div>
</div>
{assign pastEventCount 0} 
<div id="pastEvents"  class="no-display">
    <div class="container-fluid bg-light-gray eventcontainer">
        <h2 class="center"> PAST </h2>  
    </div>
    <div class="container eventwrap"> 
        <div class="col-xs-12 no-padding">
    		{$current_date = gmdate("Y-m-d H:i:s")}		
            {if isset($response.events)}
            <div id="owl-past-events" class="owl-carousel margin-bottom-20">
                {foreach $response.events as $key => $events}
    				{if (strtotime($events->server_time)<= strtotime($current_date)) && $events->status != 0 && $events->privacy != 0}
                        {assign pastEventCount $pastEventCount+1} 
                        <div ng-cloak>
                            <div class="col-xs-12 singleArticle no-padding margin-bottom-10">                  
                                <div class="col-xs-12 no-padding articleContent center">
                                    <a href="{$APP_BASE_URL}event/{$events->perma_link|lower}">
                                   {if isset($events->thumbnail_image)}
										<img src="{$APP_BASE_URL}image/events?file_name={$events->id}/{$events->thumbnail_image}" alt="" class="width_90 center-margin radius-5"/>
									{else}
										<img src="{$MEDIA_FILES_URL}uploads/images/events/img_events.jpg" alt="" class="width_90 center-margin radius-5"/>
									{/if} <button class="btn btn-box-grey col-xs-4 readmoreEvent">Read More</button></a>
                                     <a href="{$APP_BASE_URL}event/{$events->perma_link|lower}">
                                        <div class="showOnHoverEventContent">
                                            <p class="text-white text-medium margin-top-20 padding-5"><i class="text-white" class="text-white">{$events->name}</i></p>
                                            <div class="col-md-12 articleFooter no-padding">
                                                <div class="socicalIcon">
                                                    <a href="https://www.facebook.com/sharer/sharer.php?u={$APP_BASE_URL}event/{$events->perma_link|lower}" target="_blank">
                                                        <img class="margin-3" src="{$MEDIA_FILES_URL}images/facebook (2).png">
                                                    </a>
                                                    <a href="https://plus.google.com/share?url={$APP_BASE_URL}event/{$events->perma_link|lower}" target="_blank">
                                                        <img class="margin-3" src="{$MEDIA_FILES_URL}images/g+.png"></a>
                                                    <a href="https://twitter.com/home?status={$APP_BASE_URL}event/{$events->perma_link|lower}" target="_blank">
                                                        <img class="margin-3" src="{$MEDIA_FILES_URL}images/twitter (2).png"></a>
                                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={$APP_BASE_URL}event/{$events->perma_link|lower}" target="_blank">
                                                        <img class="margin-3" src="{$MEDIA_FILES_URL}images/in.png"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>              
                        </div>
    				{/if}                    
                {/foreach}
            </div> 
            {/if} 
        </div>
    </div>
</div>

<div class="container" id="noEvent">
    <h3>No Events</h3>
</div>

{/block}

{block name="js"}    
    <script src="{$MEDIA_FILES_URL}js/owl.carousel.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        pageName = "{$response.pageTitle|upper}";
        pastEventCount = {$pastEventCount};
        upcomingEventCount = {$upcomingEventCount};        

        if(upcomingEventCount > 0)
        {
            $('#upcomingEvents').show();
        }
        if(pastEventCount > 0)
        {
            $('#pastEvents').show();
        }
    </script>
{/block}