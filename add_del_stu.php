<?php
		<form>
            <table id='ADD_DEL_STU_TABLE'>
                <tr>
                    <th><button id='ADD_BUTTON' class='ASS_BUTTON' type='button'><b>+</b></button></td>
                    <th class='TITLE_TD'>Student Name</td>
                    <th class='TITLE_TD'>Account</td>
                    <th class='TITLE_TD'>Password&nbsp;&nbsp;<input type='submit' value='Save >>'></td>
                </tr>
                <tr class='HIDDEN_TR'>
                    <td><button class='ASS_BUTTON' type='button'><b>-</b></button></td>
                    <td class='CONTENT_TD'><input type='text'></td>
                    <td class='CONTENT_TD'><input type='text'></td>
                    <td class='CONTENT_TD'><input type='password'></td>
                </tr>
               <tr>
                    <td><button onclick='(function(but) {but.parentNode.parentNode.parentNode.removeChild(but.parentNode.parentNode);})(this)' class='ASS_BUTTON' type='button'><b>-</b></button></td>
                    <td class='CONTENT_TD'><input type='text' value='Abby'></td>
                    <td class='CONTENT_TD'><input type='text' value='abby8050'></td>
                    <td class='CONTENT_TD'><input type='password' value='123456'></td>
                </tr>
               <tr>
                    <td><button onclick='(function(but) {but.parentNode.parentNode.parentNode.removeChild(but.parentNode.parentNode);})(this)' class='ASS_BUTTON' type='button'><b>-</b></button></td>
                    <td class='CONTENT_TD'><input type='text' value='Abby'></td>
                    <td class='CONTENT_TD'><input type='text' value='abby8050'></td>
                    <td class='CONTENT_TD'><input type='password' value='123456'></td>
                </tr>
               <tr>
                    <td><button onclick='(function(but) {but.parentNode.parentNode.parentNode.removeChild(but.parentNode.parentNode);})(this)' class='ASS_BUTTON' type='button'><b>-</b></button></td>
                    <td class='CONTENT_TD'><input type='text' value='Abby'></td>
                    <td class='CONTENT_TD'><input type='text' value='abby8050'></td>
                    <td class='CONTENT_TD'><input type='password' value='123456'></td>
                </tr>
            </table>
		</form>
		
?>
