<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\PdfToText\Pdf;
use Livewire\WithFileUploads;

class Pdfupload extends Component
{
    use WithFileUploads;
    public $file;
    public $pdfFile, $date, $name, $amount, $address;
    // public $pdfContent;


    public function processPDF()
    {
        $validatedData = $this->validate([
            'pdfFile' => 'required|mimes:pdf|max:2048',
        ]);


        // Generate a unique file name
        $fileName = time() . '_' . $this->pdfFile->getClientOriginalName();

        // Save the PDF file to a desired directory
        $this->pdfFile->storeAs('pdfs', $fileName);

        // Get the file path of the saved PDF
        $filePath = storage_path('app/pdfs/' . $fileName);
        // dd( $filePath);

        $pdfContent = Pdf::getText($filePath);
        // dd($pdfContent);
// $this->extractAddress($pdfContent);

        // // Extract information using regular expressions or string manipulation
        $this->address = $this->extractAddress($pdfContent);
        // $this->email = $this->extractEmail($pdfContent);
        // dd($this->extractName($pdfContent));
    }


    private function extractAddress($pdfContent)
    {
        // Extract the address from the PDF content
        $address = '';

        // Find the starting and ending points of the address block
        $startMarker = 'BILLED TO';
        $endMarker = 'Phone';

        // Get the substring containing the address block
        $addressBlock = $this->getStringBetween($pdfContent, $startMarker, $endMarker);
dd($addressBlock);


        // Extract individual lines from the address block
        $lines = explode("\n", $addressBlock);

        // Remove empty lines and trim leading/trailing whitespace
        $lines = array_map('trim', array_filter($lines));

        // Concatenate the lines to form the address
        $address = implode(' ', $lines);

        return $address;
    }




    public function render()
    {
        return view('livewire.pdfupload');
    }
}
