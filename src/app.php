<?php 
    namespace MyApp;
    
    use FFMpeg\FFProbe;
    use React\Promise\Promise;

    abstract class App {

        static public function init(): void {
            require_once __DIR__ . '/views/home.phtml';
            
        }

        static public function getVideoDuration(string $filename): Promise|\Exception {
            return new Promise( function( $resolve, $reject, $notify ) use ($filename) {
                //$resolver
                try {
                    $ffprobe = FFProbe::create();
                    $duration = $ffprobe
                        ->format($filename) // extracts file informations
                        ->get('duration'); // returns the duration property;
                    $resolve($duration);
                } catch(\Exception $ex) {
                    $reject($ex);
                }
            }, function(){
                //$canceller
                throw new \Exception('Oops! Promise cancelled');
            } );
        }

        static public function getVideoDurationSync(string $filename) {
            try {
                $ffprobe = FFProbe::create();
                return $ffprobe
                    ->format($filename) // extracts file informations
                    ->get('duration'); // returns the duration property;
            } catch(\Exception $ex) {
                return $ex;
            }
        }
    }

?>