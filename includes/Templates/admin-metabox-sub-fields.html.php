<div id="nf-sub-fields">

    <table class="nf-sub-custom-fields-table">

        <thead>
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach( $fields as $field ): ?>

            <tr>
                <td><?php echo $field->get_setting( 'label' ); ?></td>

                <!-- TODO: Add form elements for editing submission data. -->
                <td><?php echo $sub->get_field_value( $field->get_id() ); ?></td>
            </tr>

        <?php endforeach; ?>
        </tbody>

    </table>

    <!-- TODO: Move to Style Sheet -->
    <style>
        .nf-sub-custom-fields-table {
            width: 100%;
        }
        .nf-sub-custom-fields-table th {
            text-align: left;
        }
        .nf-sub-custom-fields-table th,
        .nf-sub-custom-fields-table td {
            padding: 10px 0 10px 10px;
        }
        .nf-sub-custom-fields-table tbody tr:nth-child( odd ) {
            background-color: #EEE;
        }
    </style>

</div>