<?php
class Directories {
    private $baseDir = "directories";

    public function createDirectory($dirName, $fileContent) {
        $dirPath = $this->baseDir . "/" . $dirName;
        $filePath = $dirPath . "/readme.txt";

        if (file_exists($dirPath)) {
            return ["success" => false, "message" => "A directory already exists with that name."];
        }

        if (!mkdir($dirPath, 0777, true)) {
            return ["success" => false, "message" => "Failed to create the directory."];
        }

        if (file_put_contents($filePath, $fileContent) === false) {
            return ["success" => false, "message" => "Failed to create the file."];
        }

        return ["success" => true, "message" => "File and directory were created"];
    }
}
?>
