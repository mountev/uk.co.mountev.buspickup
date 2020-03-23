<div class="se-pre-con"></div>
{if $action eq 2}
  <div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="top"}
  </div>
  
  <div class="crm-copy-fields crm-grid-table" id="crm-batch-entry-table">
    <div class="crm-grid-header">
      <!-- div class="crm-grid-cell">&nbsp;</div -->
      <div class="crm-grid-cell">{$form.location.1.label}</div>
      <div class="crm-grid-cell">{$form.k2b_time.1.label}</div>
      <div class="crm-grid-cell">{$form.c2b_time.1.label}</div>
      <div class="crm-grid-cell">{$form.k2b_map.1.label}</div>
      <div class="crm-grid-cell">{$form.c2b_map.1.label}</div>
    </div>
  
    {section name='i' start=1 loop=$rowCount}
      {assign var='rowNumber' value=$smarty.section.i.index}
      <div class="{cycle values="odd-row,even-row"} selector-rows crm-grid-row" entity_id="{$rowNumber}">
        <!-- div class="compressed crm-grid-cell">{$rowNumber}</div -->
        <div class="compressed crm-grid-cell">{$form.location.$rowNumber.html}</div>
        <div class="compressed crm-grid-cell">{$form.k2b_time.$rowNumber.html}</div>
        <div class="compressed crm-grid-cell">{$form.c2b_time.$rowNumber.html}</div>
        <div class="compressed crm-grid-cell">{$form.k2b_map.$rowNumber.html}</div>
        <div class="compressed crm-grid-cell">{$form.c2b_map.$rowNumber.html}</div>
      </div>
    {/section}
  </div>
  
  <div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>
{else}
  <table class="selector" cellpadding="0" cellspacing="0" border="0">
    <tr class="columnheader">
      <th scope="col" width="30%">{ts}Location{/ts}</th>
      <th scope="col" width="20%">{ts}K2B Walkers{/ts}</th>
      <th scope="col" width="20%">{ts}C2B Walkers{/ts}</th>
      <th scope="col" width="15%">{ts}K2B Map{/ts}</th>
      <th scope="col" width="15%">{ts}C2B Map{/ts}</th>
    </tr>
    {foreach from=$rows item=row}
      <tr class="{cycle values="odd-row,even-row"} crm-buspickup-location">
        <td>{$row.location}</td>
        <td>{$row.k2b_time}</td>
        <td>{$row.c2b_time}</td>
        <td>{if $row.k2b_map}<a href="{$row.k2b_map}">{ts}K2B Map{/ts}</a>{/if}</td>
        <td>{if $row.c2b_map}<a href="{$row.c2b_map}">{ts}C2B Map{/ts}</a>{/if}</td>
      </tr>
    {/foreach}
  </table>
{/if}
