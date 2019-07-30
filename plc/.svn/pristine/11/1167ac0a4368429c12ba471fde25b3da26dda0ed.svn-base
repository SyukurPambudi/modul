<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
function to_excel($query, $filename = 'exceloutput') {
    $headers = ''; // just creating the var for field headers to append to below
    $data = ''; // just creating the var for field data to append to below

    $obj = &get_instance();

    $fields = $query->field_data();
    if ($query->num_rows() == 0)
    {
        return 'empty';
    }
    else
    {
        # Headers array
        $headers_array = array();
        
        foreach ($fields as $field)
        {
            # Add to headers
            if (!in_array($field->name,$headers_array))
            {
                $headers .= $field->name . "\t";
                $headers_array[] = $field->name;
            }

        }

        foreach ($query->result() as $row)
        {
            $line = '';
            foreach ($row as $value)
            {
                if ((!isset($value)) or ($value == ""))
                {
                    $value = "\t";
                }
                else
                {
                    $value = str_replace('"', '""', $value);
                    $value = '"' . $value . '"' . "\t";
                }
                $line .= $value;
            }
            $data .= trim($line) . "\n";
        }

        $data = str_replace("\r", "", $data);

        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=$filename.xls");
        echo "$headers\n$data";
    }
}  