<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="row">
    <div class="col-lg-12">
    <!-- <div class="challenges index large-9 medium-8 columns content"> -->
        <div class="ibox float-e-margins">
        <div class = 'ibox-title'>
            <h3><?= __('Challenges') ?></h3>
            <?php if($activeChallenge == 1){?>
            <p align="right">
            <?= $this->Html->link(__('Post Winner on Facebook'), ['action' => 'postWinner'],['class' => 'btn btn-info']) ?>
            </p>
            <?php }?>
        </div>
        <div class = "ibox-content">
                    <table class = 'table' cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('challenge_type_id') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('response') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('is_active') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('start_time') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('end_time') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('timezone') ?></th>
                                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($challenges as $key => $challenge):
                        $tz_from = 'UTC';
                        $tz_to = $challenge->timezone;
                        // Converting start-time into given Timezone.
                        $startTime = $challenge->start_time;
                        $start = new \DateTime($startTime, new \DateTimeZone($tz_from));
                        $start = $start->setTimeZone(new \DateTimeZone($tz_to))->format('Y-m-d H:i:s');

                        // Converting end-time into given Timezone.
                        $endTime = $challenge->end_time;
                        $end = new \DateTime($endTime, new \DateTimeZone($tz_from));
                        $end = $end->setTimeZone(new \DateTimeZone($tz_to))->format('Y-m-d H:i:s');

                        ?>
                        <tr>
                                        <td><?= h($key + 1) ?></td>
                                        <td><?= h($challenge->challenge_type->name)?></td>
                                        <td><?= h($challenge->name) ?></td>
                                        <td><?= h($challenge->response) ?></td>
                                        <td><?= h($challenge->is_active) ?></td>
                                        <td><?= h($start) ?></td>
                                        <td><?= h($end) ?></td>
                                        <td><?= h($challenge->timezone) ?></td>
                            <td class="actions">
                                            <?= '<a href='.$this->Url->build(['action' => 'view', $challenge->id]).' class="btn btn-xs btn-success">' ?>
                                                <i class="fa fa-eye fa-fw"></i>
                                            </a>
                                            <?= '<a href='.$this->Url->build(['action' => 'edit', $challenge->id]).' class="btn btn-xs btn-warning"">' ?>
                                                <i class="fa fa-pencil fa-fw"></i>
                                            </a>
                                            <?= $this->Form->postLink(__(''), ['action' => 'delete', $challenge->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challenge->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                                            </a>
                                        </td>
                        </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
        </div>
        
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
        </div>
    <!-- </div> -->
</div><!-- .ibox  end -->
</div><!-- .col-lg-12 end -->
</div><!-- .row end -->
