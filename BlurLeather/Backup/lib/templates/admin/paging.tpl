{if $prevLink or $nextLink or $pagination}
<p class="text">
Page :
{if empty($prevLink) eq false}
    <a href="{$prevLink.method}" title="Prev">&lt;&lt;</a>
{/if}
{foreach item=page from=$pagination}
    {if intval($startRec) eq intval($page.startRec)}
    	&nbsp;<span style="font-size:11px;font-weight:bold;">{$page.number}</span>&nbsp;
    {else}
    	&nbsp;<a href="{$page.method}" title="{$page.number}">{$page.number}</a> &nbsp;
    {/if}
{/foreach}
{if empty($nextLink) eq false}
    <a href="{$nextLink.method}" title="Next">&gt;&gt;</a>
{/if}
</p>
{/if}