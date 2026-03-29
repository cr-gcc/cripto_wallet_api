<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Services\Portfolio\PortfolioService;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
  protected $portfolioService;

  public function __construct(PortfolioService $portfolioService)
  {
    $this->portfolioService = $portfolioService;
  }

  public function index()
  {
    $portfolio = $this->portfolioService->getPortfolio();
    return response()->json($portfolio);
  }
}
