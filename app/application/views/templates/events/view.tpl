{extends file='layouts/layout.tpl'}


{block name="css"}
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/event_view.css">
{/block}

{block name="content"}
{assign event $response.event}
{$default_timezone = date_default_timezone_set($event->timezone)}

	{if empty($event) }
	
		<!-- Forum Headding -->
		<div class="viewAllArticle bg-light-gray" ng-model="type_id">
			<div class="container">
				<div class="col-xs-7 no-padding">
					<div class="font-family-light text-26 margin-vertical-10"><div class="arrow_box"></div>{$response.pageTitle|upper} </div>
				</div>
				<div class="col-xs-5 no-padding">
					<ol class="breadcrumb">
					  <li><a href="{$APP_BASE_URL}" class="text-dark-gray">Home</a></li>
					  <li><a href="{$APP_BASE_URL}events" class="text-dark-gray">Events</a></li>
					  <li class="active">View</li>
					</ol>
				</div>
			</div>
		</div>
		<br/>
		<h3 class="no-top-margin" style="text-align:center;">Event Not Found!</h3>
		
	{else}
		{$events_eb_detail = $event->eb_details->event }
		<!-- Forum Headding -->
		<div class="viewAllArticle bg-light-gray" ng-model="type_id">
			<div class="container">
				<div class="col-xs-7 no-padding">
					<div class="font-family-light text-26 margin-vertical-10"><div class="arrow_box"></div>{$response.pageTitle|upper} </div>
				</div>
				<div class="col-xs-5 no-padding">
					<ol class="breadcrumb">
					  <li><a href="{$APP_BASE_URL}" class="text-dark-gray">Home</a></li>
					  <li><a href="{$APP_BASE_URL}events" class="text-dark-gray">Events</a></li>
					  <li class="active">View</li>
					</ol>
				</div>
			</div>
		</div>
		
		{if $events_eb_detail->status != 'Draft'}
			<div class="container bg-white" ng-controller="eventController">
			
				<div class="col-xs-12 padding-vertical-50">	
					<div class="col-xs-12 col-sm-9 no-padding">
						<div class="col-xs-12 no-padding">
							<p class="text-45 font-family-bold text-metallic-blue"> {$event->name}</p>
							<p class="text-bold">{$event->start_date|date_format:'M d, Y '} @ {$event->start_date|date_format: 'h:i A '} - {$event->end_date|date_format:'M d, Y '} @ {$event->end_date|date_format: 'h:i A '} ({date("T")})</p>
							<img src="{$APP_BASE_URL}image/events?file_name={$event->id}/{$event->banner_image}" class="img-responsive" {if $event->banner_image == ''}style="display:none;"{/if}>
							<div class="text-45">
								<p>{$events_eb_detail->description}</p>
							</div>
							<p class="text-brightorange text-30 margin-bottom-20">Venue</p>
								<h3 class="name text-metallic-blue">{$events_eb_detail->venue->name}</h3>
								<p class="company text-gray text-bold no-margin">
									{if $events_eb_detail->venue->address} {$events_eb_detail->venue->address},<br/>{/if}
									{if $events_eb_detail->venue->address_2}{$events_eb_detail->venue->address_2},<br/>{/if}
									{if $events_eb_detail->venue->city}{$events_eb_detail->venue->city},{/if}
									{if $events_eb_detail->venue->region}{$events_eb_detail->venue->region},<br/>{/if}
									{if $events_eb_detail->venue->country}{$events_eb_detail->venue->country}{/if}
								</p><br/>
						</div>
						{if $events_eb_detail->status == 'Live'}
							<div class="col-xs-12 no-padding margin-top-20">
							   <div style="width:100%; text-align:left;" ><iframe  src="//eventbrite.com/tickets-external?eid={$events_eb_detail->id}&ref=etckt" frameborder="0" height="214" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe></div>
							</div>
						{/if}
						{assign speakerCount  0}						
						<div class="col-xs-12 no-padding margin-bottom-20"  id="speakers">
							<br/><br/>
							<p class="text-brightorange text-30 margin-bottom-20">Speakers</p>
							<div class="col-xs-12 no-padding">
								{foreach $response.event->participants as $key => $participants}
								{if $participants->participant->type == 'Speaker'}
									{assign speakerCount $speakerCount+1}
									<div class="col-xs-4 col-sm-3">
										<div class="participantImg">
											<img src="{$APP_BASE_URL}image/participants?file_name={$participants->participant->id}/{$participants->participant->thumbnail_image}&w=270&h=270" class="img-responsive radius-100">
										</div>
										<div class="participantDesc center">
											<h3 class="name text-metallic-blue">{$participants->participant->first_name|UPPER} {$participants->participant->last_name|UPPER}</h3>
											<p class="company text-gray text-bold no-margin">{$participants->participant->company}</p>
											<div class="profile">{$participants->participant->position}</div>
										</div>
									</div>
									{if $speakerCount%3 == 0}
										<div class="clearfix visible-xs"></div>
									{elseif $speakerCount%2 == 1}
										<div class="clearfix visible-sm"></div>
									{elseif $speakerCount%2 == 2}
										<div class="clearfix visible-md visible-lg"></div>
									{/if}
								{/if}
								{/foreach}
							</div>
						</div>
						{assign sponsorCount  0}
						<div class="col-xs-12 no-padding" id="sponsors"><br/>
							<p class="text-brightorange text-30 margin-bottom-10">Sponsors</p>
							<div class="col-xs-12 no-padding">
								{foreach $response.event->participants as $key => $participants}
								{if $participants->participant->type == 'Sponsor'}
									{assign sponsorCount  $sponsorCount+1}
									<div class="col-xs-4 col-sm-3">
										<div class="participantImg">
											<img src="{$APP_BASE_URL}image/participants?file_name={$participants->participant->id}/{$participants->participant->thumbnail_image}&w=270&h=270" class="img-responsive radius-100">
										</div>
										<div class="participantDesc center">
											<h3 class="name text-metallic-blue">{$participants->participant->first_name|UPPER} {$participants->participant->last_name|UPPER}</h3>
											<p class="company text-gray text-bold no-margin">{$participants->participant->company}</p>
											<div class="profile">{$participants->participant->position}</div>
										</div>
									</div>
									{if $sponsorCount%3 == 0}
										<div class="clearfix visible-xs"></div>
									{elseif $sponsorCount%2 == 1}
										<div class="clearfix visible-sm"></div>
									{elseif $sponsorCount%2 == 2}
										<div class="clearfix visible-md visible-lg"></div>
									{/if}
								{/if}
								{/foreach}
							</div>
						</div>
						<!-- <div class="col-xs-12 no-padding">
							<p class="text-brightorange center text-45 margin-bottom-10">Sponsors</p>
							<div class="col-xs-12 no-padding">
								{foreach $response.participants as $key => $participant}
									<div class="col-xs-3">
										<div class="participantImg">
											<img src="{$APP_BASE_URL}image/participants?file_name={$participant->thumbnail_image}" class="img-responsive">
										</div>
										<div class="participantDesc">
											<div class="name">{$participant->first_name}</div>
											<div class="company">{$participant->company}</div>
											<div class="profile">{$participant->position}</div>
										</div>
									</div>
									{if $key%3 == 0}
										<div class="clearfix visible-xs"></div>
									{elseif $key%3 == 1}
										<div class="clearfix visible-sm"></div>
									{elseif $key%3 == 2}
										<div class="clearfix visible-md visible-lg"></div>
									{/if}
								{/foreach}
							</div>
						</div> -->
					</div>
					
					<div class="col-xs-9 col-sm-3 no-padding">
						{if $events_eb_detail->status == 'Live'}
							<div class="width_100 center margin-top-20" >
								<iframe  src="https://www.eventbrite.com/countdown-widget?eid={$events_eb_detail->id}" frameborder="0" width="195" height="400" marginheight="0" marginwidth="0" scrolling="no" allowtransparency="true" class="pull-right widgetIframe"></iframe>
							</div>
						{/if}
						<div class="col-xs-12 no-padding">
							<div class="pull-right bg-light-gray radius-5 organisedBy">
								<div class="border-1-gray margin-5 radius-1">
									<p class="text-medium no-margin text-bold no-margin padding-5 bg-white"> ORGANISED BY : </p>
									<p class="text-large text-blue no-margin padding-5 bg-white"> {$events_eb_detail->organizer->name}</p>
									<p class="text-normal  no-margin padding-5 bg-white">{$events_eb_detail->organizer->description}</p>
								</div>
							</div>
						</div>
					</div>	
					{if $events_eb_detail->status == 'Live'}
						<div class="col-xs-12 no-padding center margin-top-per-6">
							<a class="btn btn-box-orange registerEventButton" href="https://www.eventbrite.com/e/testing-tickets-{$event->eb_event_id}?ref=ecount" target="_new" role="button">Register Now</a>
						</div>
					{/if}
				</div>
			</div>
		 {else}
			 <br/>
			<h3 class="no-top-margin" style="text-align:center;">Event Not Yet Published!</h3>
		{/if}
	{/if}
{/block}

{block name="js"}
	<script type="text/javascript">
		speakerCount = {$speakerCount};
		if(speakerCount == 0){
			$('#speakers').hide();
		}
		sponsorCount = {$sponsorCount};
		if(sponsorCount == 0){
			$('#sponsors').hide();
		}
	</script>
{/block}