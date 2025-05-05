<?php
class ConcreteStateA implements State {
    public function handleRequest(): void {
        echo "Обробка запиту в стані A.\n";
    }
}
