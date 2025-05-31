<?php

declare(strict_types=1);

namespace PascalKleindienst\LaravelTextToSpeech;

enum Source
{
    case Text;
    case SSML;
    case File;
}
