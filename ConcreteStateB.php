<?php
class ConcreteStateB implements State {
    public function handleRequest(): void {
        echo "Обробка запиту в стані B.\n";
    }
}
