<?php
if (isset($_SESSION["try_create_name_first"]))
{
        unset ($_SESSION["try_create_name_first"]);
        unset ($_SESSION["try_create_email"]);
}
if (isset($_SESSION["try_edit_name_first"]))
{
        unset ($_SESSION["try_edit_name_first"]);
        unset ($_SESSION["try_edit_email"]);
}