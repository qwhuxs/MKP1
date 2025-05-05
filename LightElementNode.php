<?php

class LightElementNode extends LightNode
{
    private string $tagName;
    private string $displayType;
    private string $closingType;
    private array $cssClasses = [];
    private array $attributes = [];
    private array $children = [];
    private array $hooks = [];

    public function __construct(string $tagName, string $displayType = 'block', string $closingType = 'pair')
    {
        $this->tagName = $tagName;
        $this->displayType = $displayType;
        $this->closingType = $closingType;
        $this->onCreated();
    }

    public function addHook(string $hookName, callable $hook): void
    {
        $this->hooks[$hookName] = $hook;
    }

    public function triggerHook(string $hookName): void
    {
        if (isset($this->hooks[$hookName])) {
            call_user_func($this->hooks[$hookName], $this);
        }
    }

    public function onCreated(): void
    {
        $this->triggerHook('onCreated');
    }

    public function onInserted(): void
    {
        $this->triggerHook('onInserted');
    }

    public function onRemoved(): void
    {
        $this->triggerHook('onRemoved');
    }

    public function onStylesApplied(): void
    {
        $this->triggerHook('onStylesApplied');
    }

    public function onClassListApplied(): void
    {
        $this->triggerHook('onClassListApplied');
    }

    public function onTextRendered(): void
    {
        $this->triggerHook('onTextRendered');
    }

    public function addClass(string $className): void
    {
        $this->cssClasses[] = $className;
        $this->onClassListApplied();
    }

    public function removeClass(string $className): void
    {
        $this->cssClasses = array_filter($this->cssClasses, fn($cls) => $cls !== $className);
    }

    public function setAttribute(string $name, string $value): void
    {
        $this->attributes[$name] = htmlspecialchars($value);
    }

    public function appendChild(LightNode $node): void
    {
        $this->children[] = $node;
        $this->onInserted();
    }

    public function removeChild(LightNode $node): void
    {
        foreach ($this->children as $i => $child) {
            if ($child === $node) {
                unset($this->children[$i]);
                $this->children = array_values($this->children);
                $node->onRemoved();
                break;
            }
        }
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function getChildCount(): int
    {
        return count($this->children);
    }

    public function getTagName(): string
    {
        return $this->tagName;
    }

    public function innerHTML(): string
    {
        return implode('', array_map(fn($child) => $child->outerHTML(), $this->children));
    }

    private function buildAttributes(): string
    {
        $attrs = [];

        if (!empty($this->cssClasses)) {
            $attrs[] = 'class="' . implode(' ', $this->cssClasses) . '"';
        }

        foreach ($this->attributes as $name => $value) {
            $attrs[] = "$name=\"$value\"";
        }

        return $attrs ? ' ' . implode(' ', $attrs) : '';
    }

    public function outerHTML(): string
    {
        $attrStr = $this->buildAttributes();

        if ($this->closingType === 'single') {
            return "<{$this->tagName}{$attrStr}/>";
        }

        return "<{$this->tagName}{$attrStr}>{$this->innerHTML()}</{$this->tagName}>";
    }
}
?>
