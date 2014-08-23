


    <div class="row col-12" id="mainRow">
        <!--                                Modal window for login goes here -->
        <div class="modal fade" id="loginModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4>Login window</h4>
                    </div><!-- end of modal header-->

                    <div class="modal-body">
                        <form action="" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="user">User: </label>
                                <div class="col-lg-10" >
                                    <input type="text" class="form-control" id="user" placeholder="User..."/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="pass">Password: </label>
                                <div class="col-lg-10" >
                                    <input type="text" class="form-control" id="pass" placeholder="User..."/>
                                </div>
                            </div>
                        </form>
                    </div><!-- end of modal body -->

                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal" type="button">Cancel</button>
                        <button class="btn btn-primary" data-dismiss="modal" type="button">Login</button>
                    </div>
                </div><!-- modal content end-->
            </div><!-- modal dialog end -->
        </div> <!-- end of login modal window -->

<!--        Main header: -->
        <div id="contentHeader" >
            <div class="page-header clearfix">
                <h1 class="pull-left">Questions <small>Welcome to Softuni Overflow</small></h1>
<!--                button 'NEW QUESTION'-->
                <a href="#" class="btn btn-large btn-default pull-right" id="btn-newQ" >NEW QUESTION</a>
            </div>
        </div>
        <!--        Info message for not logged in: -->
        <div class="alert alert-info alert-block fade in" id="loginAlert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>You're not logged in</h4>
            <p>Please log in to your account or create a new one to post a question.</p>
        </div>
<!--    Question blocks: -->

        <div class="well well-small">

            <h3>
                <span class='glyphicon glyphicon-file'></span>
                Question one title
            </h3>

            <p>
                Question one text goes here.Question one text goes here.Question one text goes here. <br/>
                Question one text goes here.Question one text goes here.Question one text goes here. <br/>
                Question one text goes here.Question one text goes here.Question one text goes here.
            </p>
        </div>
        <div class="well well-small">

            <h3>
                <span class='glyphicon glyphicon-file'></span>
                Question one title
            </h3>

            <p>
                Question one text goes here.Question one text goes here.Question one text goes here. <br/>
                Question one text goes here.Question one text goes here.Question one text goes here. <br/>
                Question one text goes here.Question one text goes here.Question one text goes here.
            </p>
        </div>
        <div class="well well-small">

            <h3>
                <span class='glyphicon glyphicon-file'></span>
                Question one title
            </h3>

            <p>
                Question one text goes here.Question one text goes here.Question one text goes here. <br/>
                Question one text goes here.Question one text goes here.Question one text goes here. <br/>
                Question one text goes here.Question one text goes here.Question one text goes here.
            </p>
        </div>



    </div><!-- end mainRow row -->


</div><!--end container-->