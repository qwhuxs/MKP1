<?php
interface State {
    public function handleRequest(): void;
}
