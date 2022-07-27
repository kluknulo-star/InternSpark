<?php
if (isset($_SESSION["try_title"]))
{
        unset ($_SESSION["try_title"]);
        unset ($_SESSION["try_description"]);
}
if (isset($_SESSION["try_edit_name_first"]))
{
        unset ($_SESSION["try_edit_name_first"]);
        unset ($_SESSION["try_edit_email"]);
}