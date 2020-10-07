<?php

namespace application\controllers;

use projectorangebox\dispatcher\JsonRestController;

class rest extends JsonRestController
{

  public function update($id = null)
  {
    $this->sendUpdated([
      'text' => $this->request->request('text'),
      'age' => $this->request->request('age'),
    ]);
  }

  public function create()
  {
    $this->sendCreated([
      'text' => $this->request->request('text'),
      'age' => $this->request->request('age'),
    ]);
  }
} /*end class */