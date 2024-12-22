<template>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <div id="logo_home">
                        <h1><a href="/">sOne</a></h1>
                    </div>
                </div>
                <div class="col-9">
                    <div id="social">
                        <ul>
                            <!--li><a href="#0"><i class="bi bi-facebook"></i></a></li>
							<li><a href="#0"><i class="bi bi-twitter-x"></i></a></li>
							<li><a href="#0"><i class="bi bi-instagram"></i></a></li>
							<li><a href="#0"><i class="bi bi-linkedin"></i></a></li-->
                            <li>
                                <!--select class="languages">
                                    <option value="en" selected>English</option>
                                    <option value="de">Deutsch</option>
                                    <option value="ru">Русский</option>
                                </select-->
                                <SelectLanguages />
                            </li>
                        </ul>
                    </div>
                    <!-- /social -->
                    <!--nav>
                        <ul class="cd-primary-nav">
                            <li><a href="about.html.htm" class="animated_link">About</a></li>
                            <li><a href="contacts.html.htm" class="animated_link">Contacts</a></li>
                            <li><a href="icon-pack-1.html.htm" class="animated_link">Icon Pack One</a></li>
                            <li><a href="icon-pack-2.html.htm" class="animated_link">Icon Pack Two</a></li>
                            <li><a href="icon-pack-3.html.htm" class="animated_link">Icon Pack Three</a></li>
                        </ul>
                    </nav-->
                </div>
            </div>
        </div>
        <!-- /container -->
    </header>
</template>
<script>
import SelectLanguages from "../elements/SelectLanguages.vue";

export default {
    components: {
        SelectLanguages,
    },
};
</script>
<style>

</style>
