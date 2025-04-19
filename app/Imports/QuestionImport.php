<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\Option;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



 class QuestionImport implements ToModel, WithBatchInserts, WithChunkReading, ShouldQueue
    {


    public function __construct($course_id,$category_id,$sub_category_id,$sub_sub_category_id,$user_id)
    {
        $this->course_id = $course_id;
        $this->category_id = $category_id;
        $this->sub_category_id = $sub_category_id;
        $this->sub_sub_category_id = $sub_sub_category_id;
        $this->user_id = $user_id;
    }


    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function batchSize(): int
    {
        return 1000; // Set your desired batch size here
    }

    public function chunkSize(): int
    {
        return 1000; // Set your desired chunk size here
    }



    public function model(array $row)
{
    // Create and save the question
    $question = new Question([
        'course_id'           => $this->course_id,
        'category_id'         => $this->category_id,
        'sub_category_id'     => $this->sub_category_id,
        'sub_sub_category_id' => $this->sub_sub_category_id,
        'title'               => $row[0],
        'created_by'          => $this->user_id,
    ]);

    $question->save(); // Save to get the question ID

    // Loop through options: assumes format [1 => option1, 2 => is_correct1, 3 => option2, 4 => is_correct2, etc.]
    for ($i = 1; $i <= 9; $i += 2) {
        if (!empty($row[$i])) {
            $option = new Option([
                'question_id' => $question->id,
                'option'      => $row[$i],
                'is_correct'  => $row[$i + 1] ?? 0,
                'created_by'  => $this->user_id,
            ]);
            $option->save();
        }
    }

    echo $question;
}


}