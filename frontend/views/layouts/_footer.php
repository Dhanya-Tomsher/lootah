<footer id="footer" class="footer-area bg-2 bg-opacity-black-90">
    <?php $get_config = \common\models\Configuration::find()->where(['status' => 1, 'platform' => 'WEB'])->one(); ?>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xs-4">
                    <div class="copyright text-left">
                        <p>Copyright &copy; <?php echo date('Y'); ?>  <a href="#"><b>Lootah Biofuels - <?php echo date('Y'); ?></b></a>. All rights reserved.</p>
                    </div>
                </div>
                <div class="col-xs-8">
                    <div class="copyright text-right social-media">
                        <p>
                            
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End footer area -->
</div>
