
{extends file='page.tpl'}
{block name="page_title"}
    <header class="page-header">
        <h1>{$header_title}</h1>
    </header>
{/block}

{block name="page_content"}

    <h2> Pobieranie XML</h2>

    <p>
       <b>Twój token dostępowy:</b>  {$token_xml} <br>
        <b>Twój identyfikator użytkownika:</b>{$id_customer}
    </p>

    {foreach from=$viewFeedList item=foo}
        <p>

            {$foo.name}  {$foo.desc}:  <a href="{$foo.link}"> {$foo.link} </a>
        </p>

    {/foreach}




{/block}

