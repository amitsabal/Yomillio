{extends file='layouts/layout.tpl'}
{block name="content"}

<script type="text/javascript">
    
</script>

<div class="col-md-12">
	<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12" style="text-align: center;">
		<span class="message">{if isset($response.warningmessage) && $response.warningmessage != ''}{$response.warningmessage}{else if isset($response.successmessage) && $response.successmessage != ''}{$response.successmessage}{/if}</span>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12" style="{if isset($response.successmessage) && $response.successmessage != ''}display:none;{else}display:block;{/if}">
		<a href="{$APP_BASE_URL}linkedin/linkedin.php">
			<img src="{$MEDIA_FILES_URL}images/linkedin_connect_button.png" alt="Sign in with LinkedIn" class="linkedinbtn"/>
		</a>
	</div>
</div>
<div class="col-md-4">
</div>

{/block}