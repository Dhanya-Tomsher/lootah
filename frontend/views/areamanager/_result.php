 <tr>                                               
                                                <td class="name"><?= $i; ?></td>
                                                <td><?= date('m-d-Y',strtotime($dib->purchase_date)); ?></td>
                                                <td><?php echo \common\models\LbStation::find()->where(['id' => $dib->station_id])->one()->station_name; ?></td>
                                                <td><?php echo \common\models\LbClientVehicles::find()->where(['id' => $dib->vehicle_id])->one()->vehicle_number; ?></td>
						<td><?php echo $dib->odometer_reading; ?></td>
						<td><?php echo $dib->quantity_litre; ?></td>
						<td><?php echo $dib->amount; ?> AED</td>
                                            </tr>