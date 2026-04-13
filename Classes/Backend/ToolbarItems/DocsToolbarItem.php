<?php

declare(strict_types=1);

namespace GeorgRinger\Docs\Backend\ToolbarItems;

use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\SystemResource\Publishing\SystemResourcePublisherInterface;
use TYPO3\CMS\Core\SystemResource\SystemResourceFactory;
use TYPO3\CMS\Core\Utility\PathUtility;

class DocsToolbarItem implements ToolbarItemInterface
{
    private string $docUrl;

    public function __construct(
        private readonly PageRenderer $pageRenderer,
        private readonly SystemResourceFactory $systemResourceFactory,
        private readonly SystemResourcePublisherInterface $systemResourcePublisher,
        ExtensionConfiguration $extensionConfiguration,
    ) {
        $rawUrl = (string)$extensionConfiguration->get('docs', 'docUrl');
        $this->docUrl = $this->resolveUrl($rawUrl);
        $this->pageRenderer->loadJavaScriptModule('@georgringer/docs/docs-toolbar.js');
    }

    public function checkAccess(): bool
    {
        return true;
    }

    public function getItem(): string
    {
        $title = htmlspecialchars($this->translate('toolbar.title'));
        $modalTitle = htmlspecialchars($this->translate('modal.title'));
        $url = htmlspecialchars($this->docUrl);

        return '<a href="#" class="toolbar-item-link" data-docs-toolbar-trigger'
            . ' data-docs-url="' . $url . '"'
            . ' data-docs-title="' . $modalTitle . '"'
            . ' title="' . $title . '">'
            . '<span class="toolbar-item-icon">'
            . '<typo3-backend-icon identifier="actions-system-help-open" size="small"></typo3-backend-icon>'
            . '</span>'
            . '</a>';
    }

    public function hasDropDown(): bool
    {
        return false;
    }

    public function getDropDown(): string
    {
        return '';
    }

    public function getAdditionalAttributes(): array
    {
        return [];
    }

    public function getIndex(): int
    {
        return 50;
    }

    private function resolveUrl(string $path): string
    {
        if (!PathUtility::isExtensionPath($path)) {
            return $path;
        }
        try {
            $resource = $this->systemResourceFactory->createPublicResource($path);
            return (string)$this->systemResourcePublisher->generateUri($resource, null);
        } catch (\Throwable) {
            return $path;
        }
    }

    private function translate(string $key): string
    {
        return $GLOBALS['LANG']->sL('LLL:EXT:docs/Resources/Private/Language/locallang.xlf:' . $key);
    }
}
