<!-- CONTENT -->

<?php 
use App\Models\ExpedientesModel;
$modelExp = new ExpedientesModel();
$felibP1 = $modelExp->getTotalFelibCityCouncils('felib_p1');
$felibP1CouncilList = $modelExp->getCityCouncilsList('felib_p1');
$felibP2 = $modelExp->getTotalFelibCityCouncils('felib_p2');
$felibP2CouncilList = $modelExp->getCityCouncilsList('felib_p2');
$felibP3 = $modelExp->getTotalFelibCityCouncils('felib_p3');
$felibP3CouncilList = $modelExp->getCityCouncilsList('felib_p3');
$felibP4 = $modelExp->getTotalFelibCityCouncils('felib_p4');
$felibP4CouncilList = $modelExp->getCityCouncilsList('felib_p4');
$felibP5 = $modelExp->getTotalFelibCityCouncils('felib_p5');
$felibP5CouncilList = $modelExp->getCityCouncilsList('felib_p5');
$felibP6 = $modelExp->getTotalFelibCityCouncils('felib_p6');
$felibP6CouncilList = $modelExp->getCityCouncilsList('felib_p6');
$felibP7 = $modelExp->getTotalFelibCityCouncils('felib_p7');
$felibP7CouncilList = $modelExp->getCityCouncilsList('felib_p7');
$felibP8 = $modelExp->getTotalFelibCityCouncils('felib_p8');
$felibP8CouncilList = $modelExp->getCityCouncilsList('felib_p8');
$felibP9 = $modelExp->getTotalFelibCityCouncils('felib_p9');
$felibP9CouncilList = $modelExp->getCityCouncilsList('felib_p9');
$felibP10 = $modelExp->getTotalFelibCityCouncils('felib_p10');
$felibP10CouncilList = $modelExp->getCityCouncilsList('felib_p10');
$felibP11 = $modelExp->getTotalFelibCityCouncils('felib_p11');
$felibP11CouncilList = $modelExp->getCityCouncilsList('felib_p11');
$felibP12 = $modelExp->getTotalFelibCityCouncils('felib_p12');
$felibP12CouncilList = $modelExp->getCityCouncilsList('felib_p12');
$felibP13 = $modelExp->getTotalFelibCityCouncils('felib_p13');
$felibP13CouncilList = $modelExp->getCityCouncilsList('felib_p13');
$felibP14 = $modelExp->getTotalFelibCityCouncils('felib_p14');
$felibP14CouncilList = $modelExp->getCityCouncilsList('felib_p14');
$felibP15 = $modelExp->getTotalFelibCityCouncils('felib_p15');
$felibP15CouncilList = $modelExp->getCityCouncilsList('felib_p15');
?>
<div class="row">
  <div class="col">
	<div id="body">
    <h1>Resum FELIB</h1>
    <h2>Programes sol·licitats:</h2>
    <div>
        <ul>
        <li for = "felib_p1" class="main" >
					<?php echo lang('message_lang.felib_short_p1').": <span class='alert alert-info'>".$felibP1;?> ajuntaments</span>
          <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php if ($felibP1CouncilList) {?>
            <?php foreach($felibP1CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
            <?php }?>
          </div>  
				</li>

        <li for = "felib_p2" class="main" >
					<?php echo lang('message_lang.felib_short_p2').": <span class='alert alert-info'>".$felibP2;?> ajuntaments</span>
            <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php if ($felibP2CouncilList) {?>
            <?php foreach($felibP2CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
            <?php }?>
          </div>
				</li>

        <li for = "felib_p3" class="main" >
					<?php echo lang('message_lang.felib_short_p3').": <span class='alert alert-info'>".$felibP3;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php if ($felibP3CouncilList) {?>            
            <?php foreach($felibP3CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
            <?php }?>
          </div>
				</li>

        <li for = "felib_p4" class="main" >
					<?php echo lang('message_lang.felib_short_p4').": <span class='alert alert-info'>".$felibP4;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php if ($felibP4CouncilList) {?>
            <?php foreach($felibP4CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
            <?php }?>
          </div>
				</li>

        <li for = "felib_p5" class="main" >
					<?php echo lang('message_lang.felib_short_p5').": <span class='alert alert-info'>".$felibP5;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php if ($felibP5CouncilList) {?>
            <?php foreach($felibP5CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
            <?php }?> 
          </div>
				</li>

        <li for = "felib_p6" class="main" >
					<?php echo lang('message_lang.felib_short_p6').": <span class='alert alert-info'>".$felibP6;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php if ($felibP6CouncilList) {?>
            <?php foreach($felibP6CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
            <?php }?> 
          </div>
				</li>

        <li for = "felib_p7" class="main" >
					<?php echo lang('message_lang.felib_short_p7').": <span class='alert alert-info'>".$felibP7;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php if ($felibP7CouncilList) {?>
            <?php foreach($felibP7CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
            <?php }?>
          </div>
				</li>

        <li for = "felib_p8" class="main" >
					<?php echo lang('message_lang.felib_short_p8').": <span class='alert alert-info'>".$felibP8;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php if ($felibP8CouncilList) {?>
            <?php foreach($felibP8CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
            <?php }?>
          </div>
				</li>

        <li for = "felib_p9" class="main" >
					<?php echo lang('message_lang.felib_short_p9').": <span class='alert alert-info'>".$felibP9;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php if ($felibP9CouncilList) {?>
            <?php foreach($felibP9CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
            <?php }?>
          </div>
				</li>

        <li for = "felib_p10" class="main" >
					<?php echo lang('message_lang.felib_short_p10').":<span class='alert alert-info'> ".$felibP10;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php if ($felibP10CouncilList) {?>
            <?php foreach($felibP10CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
            <?php }?>
          </div>
				</li>

        <li for = "felib_p11" class="main" >
					<?php echo lang('message_lang.felib_short_p11').":<span class='alert alert-info'> ".$felibP11;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php if ($felibP11CouncilList) {?>
            <?php foreach($felibP11CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
            <?php }?>
          </div>
				</li>

        <li for = "felib_p12" class="main" >
					<?php echo lang('message_lang.felib_short_p12').":<span class='alert alert-info'> ".$felibP12;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php if ($felibP12CouncilList) {?>
            <?php foreach($felibP12CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
            <?php }?>
          </div>
				</li>

        <li for = "felib_p13" class="main" >
					<?php echo lang('message_lang.felib_short_p13').":<span class='alert alert-info'> ".$felibP13;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php if ($felibP13CouncilList) {?>
            <?php foreach($felibP13CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
            <?php }?>
          </div>
				</li>

        <li for = "felib_p14" class="main" >
					<?php echo lang('message_lang.felib_short_p14').":<span class='alert alert-info'> ".$felibP14;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php if ($felibP14CouncilList) {?>
            <?php foreach($felibP14CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
            <?php }?>
          </div>
				</li>

        <li for = "felib_p15" class="main" >
					<?php echo lang('message_lang.felib_short_p15').":<span class='alert alert-info'> ".$felibP15;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php if ($felibP15CouncilList) {?>
            <?php foreach($felibP15CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
            <?php }?>
          </div>
				</li>
        </ul>
    </div>
</div>

  </div>
</div>



<style>
.alert {
  padding: 0;
}  
.lista-exped-wrapper {
  width: 100%;
}
.header-wrapper {
  display: inline-grid;
  grid-template-columns: 33% 33% 33%;
  padding-bottom: 4px;
  width: 100%;
}

.header-wrapper-col {
  background-color: #003747;
  color: #fff;
  border: 1px solid rgba(0, 0, 0, 0.8);
  padding: 4px;
  text-align: left;
}
.detail-wrapper {
  display: inline-grid;
  grid-template-columns: 33% 33% 33%;
  background-color: #f1efef;
  padding: 1px 0 1px 0;
  width: 100%;
}
</style>