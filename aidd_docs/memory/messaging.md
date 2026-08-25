# Messaging

The project's async message processing setup.

## Stack

- Symfony Messenger component
- Doctrine Messenger transport
- Async message handling

## Current state

- Messenger configured with Doctrine transport
- No message classes defined yet
- No message handlers created yet
- Ready for async processing workflows

## Configuration

- Messenger configuration in config/packages/messenger.yaml
- Doctrine transport for persistence
- Serializer for message normalization

## Message flow

- Messages dispatched via MessageBus
- Transport handles async processing
- Handlers process messages when consumed
