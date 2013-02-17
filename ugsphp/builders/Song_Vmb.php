<?php


/**
 * View Model Builder -- Creates a "Song" View Model
 * @class Song_Vmb
 */
class Song_Vmb {

	/**
	 * Parses file (using URL query param) and attempts to load View Model
	 * @return Song_Vm
	 */
	public function Build() {
		$filename = FileHelper::getFilename();
		$fileContent = FileHelper::getFile(Config::$SongDirectory . $filename);
		$song = SongHelper::parseSong($fileContent);

		$title = htmlspecialchars((($song->isOK) ? ($song->title . ((strlen($song->subtitle) > 0) ? (' | ' . $song->subtitle) : '')) : 'Not Found'));

		$viewModel = new Song_Vm();
		$viewModel->PageTitle = ((strlen($title) > 0) ? $title : $filename) . ' ' . Config::PageTitleSuffix;
		$viewModel->SongTitle = htmlspecialchars($song->title);
		$viewModel->Subtitle = htmlspecialchars($song->subtitle);
		$viewModel->Artist = $song->artist;
		$viewModel->Album = $song->album; // htmlspecialchars();
		$viewModel->Body = $song->body;
		$viewModel->UgsMeta = $song->meta;
		$viewModel->SourceUri = Ugs::MakeUri(Actions::Source, $filename);
		$viewModel->EditUri = Ugs::MakeUri(Actions::Edit, $filename);

		return $viewModel;
	}
}