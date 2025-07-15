<?php

namespace app\controllers;

use app\models\Loan;
use app\models\Book;
use app\models\Member;

use Yii;

class LoanController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $loans = Loan::find()->all();
        return $this->asJson($loans);
    }

    public function actionBorrow() {
        $request = Yii::$app->request;

        $bookId = $request->post('book_id');
        $book = Book::findOne($bookId);

        if (is_null($book)) {
            return $this->errorResponse('Book not found');
        }

        if (!$book->is_available_for_loan) {
            return $this->errorResponse('Book unavailable');
        }

        $borrowerId = $request->post('member_id');

        if (is_null(Member::findOne($borrowerId))) {
            return $this->errorResponse('Member not found');
        }

        $loan = new Loan();
        $returnDate = strtotime('+ 1 month');
        $loan->attributes = [
            'book_id' => $bookId,
            'borrower_id' => $borrowerId,
            'borrowed_on' => date('Y-m-d H:i:s'),
            'to_be_returned_on' => date('Y-m-d H:i:s', $returnDate)
        ];

        $book->markAsBorrowed();
        $loan->save();

        return $this->asJson($loan);
    }

    private function errorResponse($message)
    {
        Yii::$app->response->statusCode = 400;

        return $this->asJson(['error' => $message]);
    }
}
