<!-- Article Tags Starts -->
<div class="articleTagsDiv col-xs-12 no-padding margin-top-30" {if $article->tags|@count == 0} style="display:none" {/if}>
    <p>
         <div class="articleTagHeading col-xs-12 no-padding">
            <h4 class="text-bold text-gray padding-vertical-10">TAGS </h4>
        </div>
        {foreach  from=$article->tags item=tag}
        {if $article->type_id == 1}
        <span class="articleTag"><a href="{$APP_BASE_URL}articles/tag/{$tag|lower}">{$tag}</a></span>
        {else}
        <span class="articleTag"><a href="{$APP_BASE_URL}insights/tag/{$tag|lower}">{$tag}</a></span>
        {/if}
        {/foreach}
    </p>
</div>
<!-- Article Tags Ends -->